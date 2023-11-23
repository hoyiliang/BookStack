<div component="dropdown"
     class="dropdown-container"
     id="share-book">

    <div refs="dropdown@toggle"
         class="icon-list-item"
         aria-haspopup="true"
         aria-expanded="false"
         aria-label="{{ trans('entities.share') }}"
         data-shortcut="share"
         tabindex="0">
        <span>@icon('share')</span>
        <span>{{ trans('entities.share') }}</span>
    </div>

    <ul refs="dropdown@menu" class="wide dropdown-menu" role="menu">
        <li>
        <a href="#" data-url="hello world" onclick="copyToClipboard('{{ $entity->getWhatsappUrl() }}')" class="label-item copy-link">
            <span>@icon('share')</span><span>Link</span>
        </a>
    </li>
        <!-- <li><a href="https://wa.me/?text={{ $entity->getWhatsappUrl() }}" target="_blank" class="label-item"><span>@icon('share')</span><span>Link</span></a></li> -->
        <li><a href="https://wa.me/?text={{ $entity->getWhatsappUrl() }}" target="_blank" class="label-item"><span>@icon('whatsapp')</span><span>Whatsapp</span></a></li>
        <li><a href="{{ $entity->getEmailUrl() }}" target="_blank" class="label-item"><span>@icon('email')</span><span>Email</span></a></li>
    </ul>
</div>