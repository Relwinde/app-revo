<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">

            {{-- Titre principal --}}
            <h1 class="flex-sm-fill h3 my-2">
                {{ $title ?? 'Titre par défaut' }}

                {{-- Sous-titre optionnel --}}
                @if(isset($subtitle))
                <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">
                    {{ $subtitle }}
                </small>
                @endif
            </h1>

            {{-- Breadcrumb --}}
            @if(isset($breadcrumbs) && is_array($breadcrumbs))
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    @foreach($breadcrumbs as $item)
                    @if($loop->last)
                    <li class="breadcrumb-item active" aria-current="page">{{ $item['label'] }}</li>
                    @else
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ $item['url'] ?? '#' }}">{{ $item['label'] }}</a>
                    </li>
                    @endif
                    @endforeach
                </ol>
            </nav>
            @endif

        </div>
    </div>
</div>