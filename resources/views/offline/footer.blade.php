<?php
use App\Helpers\SoftwareUpdater;
?>
<section id="imet_footer">

    <!-- Version -->
    <div>
        @lang('offline.version'): <span class="font-bold text-primary-600">{{ config('nativephp.version')  }}</span>
    </div>

    <div></div>

    <!-- Copyright -->
    <div class="font-bold">{{ config('nativephp.copyright') }}</div>

</section>
