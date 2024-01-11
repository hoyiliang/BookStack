import {Component} from './component';
import {getLoading, htmlToDom} from '../services/dom';

export class PageComments extends Component {

    setup() {
        this.elem = this.$el;
        this.pageId = Number(this.$opts.pageId);

        // Element references
        this.container = this.$refs.commentContainer;
        this.commentCountBar = this.$refs.commentCountBar;
        this.commentsTitle = this.$refs.commentsTitle;
        this.addButtonContainer = this.$refs.addButtonContainer;
        this.replyToRow = this.$refs.replyToRow;
        this.formContainer = this.$refs.formContainer;
        this.form = this.$refs.form;
        this.formInput = this.$refs.formInput;
        this.formReplyLink = this.$refs.formReplyLink;
        this.addCommentButton = this.$refs.addCommentButton;
        this.hideFormButton = this.$refs.hideFormButton;
        this.removeReplyToButton = this.$refs.removeReplyToButton;
        this.showMoreButton = this.$refs.showMoreButton;
        this.allCommentContainer = this.$refs.allCommentContainer;
        this.numContainerDelete = 0;

        // Translations
        this.createdText = this.$opts.createdText;
        this.countText = this.$opts.countText;

        // Internal State
        this.parentId = null;
        this.formReplyText = this.formReplyLink?.textContent || '';

        this.setupListeners();
    }

    setupListeners() {
        this.elem.addEventListener('page-comment-delete', () => {
            // const count = this.getCommentCount() - 1;
            // this.commentsTitle.textContent = window.trans_plural(this.countText, count, {count});
            // this.numContainerDelete++; 
            this.showMore();
            // this.updateCount();
            // this.hideForm();
        });

        this.elem.addEventListener('page-comment-reply', event => {
            this.setReply(event.detail.id, event.detail.element);
        });

        // this.elem.addEventListener('page-comment-display-all', () => {
        //     this.showMore();
        // });

        // this.elem.addEventListener('click', (event) => {
        //     if (event.target.id === 'show-more-btn') {
        //         this.showMore();
        //     }
        // });

        if (this.form) {
            this.removeReplyToButton.addEventListener('click', this.removeReplyTo.bind(this));
            // this.hideFormButton.addEventListener('click', this.hideForm.bind(this));
            // this.addCommentButton.addEventListener('click', this.showForm.bind(this));
            this.form.addEventListener('submit', this.saveComment.bind(this));
            this.showMoreButton.addEventListener('click', this.showMore.bind(this));
        }
    }

    showMore() {
        this.container.toggleAttribute('hidden', true);
        this.allCommentContainer.toggleAttribute('hidden', false);
    }

    saveComment(event) {
        event.preventDefault();
        event.stopPropagation();

        const loading = getLoading();
        loading.classList.add('px-l');
        this.form.after(loading);
        this.form.toggleAttribute('hidden', true);

        const text = this.formInput.value;
        const reqData = {
            text,
            parent_id: this.parentId || null,
        };

        window.$http.post(`/comment/${this.pageId}`, reqData).then(resp => {
            const newElem = htmlToDom(resp.data);
            this.container.append(newElem); // ori: this.formContainer.before(newElem);
            this.allCommentContainer.append(newElem);
            window.$events.success(this.createdText);
            // this.resetForm(); // ori: this.hideForm();
            this.formInput.value = '';
            // const count = this.getCommentCount() + 1;
            // this.commentsTitle.textContent = window.trans_plural(this.countText, count, {count});
            // this.updateCount();
            this.showMore();
        }).catch(error => {
            console.log(error)
            if (error.response && error.response.status === 422) {
                // Validation error
                window.$events.showValidationErrors(error);
            } else {
                // General error, show a generic message
                window.$events.error('An error occurred while submitting the comment. Please try again.');
            }
        }).finally(() => {
            this.form.toggleAttribute('hidden', false);
            loading.remove();
        });
    }

    updateCount() {
        const count = this.getCommentCount();
        this.commentsTitle.textContent = window.trans_plural(this.countText, count, {count});
    }

    resetForm() {
        this.formInput.value = '';
        this.parentId = null;
        this.replyToRow.toggleAttribute('hidden', true);
        this.container.append(this.formContainer);
    }

    showForm() {
        this.formContainer.toggleAttribute('hidden', false);
        // this.addButtonContainer.toggleAttribute('hidden', true);
        this.formContainer.scrollIntoView({behavior: 'smooth', block: 'nearest'});
        setTimeout(() => {
            this.formInput.focus();
        }, 100);
    }

    hideForm() {
        this.resetForm();
        this.formContainer.toggleAttribute('hidden', true);
        if (this.getCommentCount() > 0) {
            this.elem.append(this.addButtonContainer);
        } else {
            this.commentCountBar.append(this.addButtonContainer);
        }
        this.addButtonContainer.toggleAttribute('hidden', false);
    }

    getCommentCount() {
        return this.allCommentContainer.querySelectorAll('[component="page-comment"]').length;
    }

    setReply(commentLocalId, commentElement) {
        const targetFormLocation = commentElement.closest('.comment-branch').querySelector('.comment-branch-children');
        targetFormLocation.append(this.formContainer);
        this.showForm();
        this.parentId = commentLocalId;
        this.replyToRow.toggleAttribute('hidden', false);
        this.formReplyLink.textContent = this.formReplyText.replace('1234', this.parentId);
        this.formReplyLink.href = `#comment${this.parentId}`;
    }

    removeReplyTo() {
        this.parentId = null;
        this.replyToRow.toggleAttribute('hidden', true);
        this.container.append(this.formContainer);
        this.showForm();
    }
}
