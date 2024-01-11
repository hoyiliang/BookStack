import {Component} from './component';
import {getLoading, htmlToDom} from '../services/dom';

export class PageComment extends Component {

    setup() {
        // Options
        this.commentId = this.$opts.commentId;
        this.commentLocalId = this.$opts.commentLocalId;
        this.commentParentId = this.$opts.commentParentId;
        this.deletedText = this.$opts.deletedText;
        this.updatedText = this.$opts.updatedText;

        // Element References
        this.container = this.$el;
        this.contentContainer = this.$refs.contentContainer;
        this.form = this.$refs.form;
        this.formCancel = this.$refs.formCancel;
        this.editButton = this.$refs.editButton;
        this.deleteButton = this.$refs.deleteButton;
        this.replyButton = this.$refs.replyButton;
        this.input = this.$refs.input;

        this.setupListeners();
    }

    setupListeners() {
        if (this.replyButton) {
            this.replyButton.addEventListener('click', () => this.$emit('reply', {
                id: this.commentLocalId,
                element: this.container,
            }));
        }

        if (this.editButton) {
            this.editButton.addEventListener('click', this.startEdit.bind(this));
            this.form.addEventListener('submit', this.update.bind(this));
            this.formCancel.addEventListener('click', () => this.toggleEditMode(false));
        }

        if (this.deleteButton) {
            this.deleteButton.addEventListener('click', this.delete.bind(this));
        }
    }

    toggleEditMode(show) {
        this.contentContainer.toggleAttribute('hidden', show);
        this.form.toggleAttribute('hidden', !show);
    }

    startEdit() {
        this.toggleEditMode(true);
        const lineCount = this.$refs.input.value.split('\n').length;
        this.$refs.input.style.height = `${(lineCount * 20) + 40}px`;
    }

    async update(event) {
        event.preventDefault();
        const loading = this.showLoading();
        this.form.toggleAttribute('hidden', true);

        const reqData = {
            text: this.input.value,
            parent_id: this.parentId || null,
        };

        try {
            const resp = await window.$http.put(`/comment/${this.commentId}`, reqData);
            const newComment = htmlToDom(resp.data);
            this.container.replaceWith(newComment);
            window.$events.success(this.updatedText);
        } catch (err) {
            console.error(err);
            window.$events.showValidationErrors(err);
            this.form.toggleAttribute('hidden', false);
            loading.remove();
        }
    }

    delete() {
        // this.showLoading();
        // window.$http.delete(`/comment/${this.commentId}`);
        // this.container.closest('.comment-branch').remove();
        // // this.$emit('delete');
        // window.$events.success(this.deletedText);
        // console.log("delete method finished.")
        // location.reload();

        this.showLoading();
        window.$http.delete(`/comment/${this.commentId}`);

        const commentBranch = this.container.closest('.comment-branch');

        if (commentBranch) {
            // Display success message
            window.$events.success(this.deletedText);

            // Remove comment branch after 1 second
            setTimeout(() => {
                commentBranch.remove();

                // Reload the page
                // eslint-disable-next-line no-restricted-globals
                location.reload();
            }, 1000);
        } else {
            console.error('Comment branch not found.');
        }
    }

    showLoading() {
        const loading = getLoading();
        loading.classList.add('px-l');
        this.container.append(loading);
        return loading;
    }

}
