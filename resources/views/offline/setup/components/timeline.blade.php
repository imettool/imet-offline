<?php
/** @var array $timeline */
/** @var string $current_step */

$is_prev_step = true;
$is_current_step = false;

?>

<div class="flex w-full gap-4 mx-4 justify-around
     relative before:absolute before:inset-0 before:mt-5 before:-translate-y-px before:w-full before:h-0.5 before:bg-gradient-to-l before:from-transparent before:via-slate-300 before:to-transparent">

    @foreach($timeline as $idx => $item)

        @php
            if($idx === $current_step){
                $is_prev_step = false;
                $is_current_step = true;
            } else if(!$is_prev_step){
                $is_current_step = false;
            }
        @endphp

        <div class="flex flex-col items-center gap-2 group @if($is_prev_step) is-active @endif">

            <!-- Icon -->
            <div class="z-1 flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-300 group-[.is-active]:bg-emerald-500 group-[.is-active]:text-emerald-50 shadow shrink-0">
                @if($is_prev_step)
                    <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="12" height="10">
                        <path fill-rule="nonzero" d="M10.422 1.257 4.655 7.025 2.553 4.923A.916.916 0 0 0 1.257 6.22l2.75 2.75a.916.916 0 0 0 1.296 0l6.415-6.416a.916.916 0 0 0-1.296-1.296Z" />
                    </svg>
                @elseif($is_current_step)
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" height="20">
                        <path d="M297.4 566.6C309.9 579.1 330.2 579.1 342.7 566.6L502.7 406.6C515.2 394.1 515.2 373.8 502.7 361.3C490.2 348.8 469.9 348.8 457.4 361.3L352 466.7L352 96C352 78.3 337.7 64 320 64C302.3 64 288 78.3 288 96L288 466.7L182.6 361.3C170.1 348.8 149.8 348.8 137.3 361.3C124.8 373.8 124.8 394.1 137.3 406.6L297.3 566.6z"/></svg>
                    </svg>
                @endif
            </div>

            <!-- Card -->
            <div class="bg-white p-4 rounded border border-slate-200 shadow">
                <div class="font-bold text-nowrap text-slate-900 mb-1">{{ $item['title'] }}</div>
                @if($is_current_step)
                    <div class="italic text-sm mb-2">{{ $item['description'] }}</div>
                @endif
            </div>

        </div>

    @endforeach

</div>
