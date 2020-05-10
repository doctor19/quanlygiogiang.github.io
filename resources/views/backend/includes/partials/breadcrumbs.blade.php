@if ($breadcrumbs)
    <ol class="breadcrumb" style="float:left;font-size:16px">
        @foreach ($breadcrumbs as $breadcrumb)
            @if (isset($breadcrumb->url))
                <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
            @else
                <li class="active">{{ $breadcrumb->title }}</li>
            @endif
        @endforeach
    </ol>
@endif