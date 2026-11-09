<?php

use Illuminate\Support\Facades\App;
use ModularForms\Helpers\Template;

?>

<a>{!! Template::flag(strtolower(App::getLocale()), '') !!}</a>
<ul class="language_selector">
    <li>@lang('imet-core::common.switch_language'):</li>
    @foreach(trans('imet-core::common.languages') as $lang=>$label)
        <li>
            <a href="{{ url()->current() }}?lang={{ $lang }}">
                {!! Template::flag($lang, '') !!}
                {{ ucfirst($label) }}
            </a>
        </li>
    @endforeach
</ul>
