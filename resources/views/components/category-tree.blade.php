@props(['nodes','activeCat'])

<ul class="sidebar-list {{ $attributes->get('class') }}">
@foreach($nodes as $node)
    @php
        $isActive = $activeCat && $activeCat->id === $node->id;
        $hasChild = $node->children->isNotEmpty();
    @endphp

    <li>
        <a href="{{ route('products.index', ['cat' => $node->slug]) }}"
           class="{{ $isActive ? 'active' : '' }}">
            <span>{{ $node->name }}</span>
            @if ($hasChild)
                <span class="icon fa fa-angle-right"></span>
            @endif
        </a>

        @if ($hasChild)
            <x-category-tree :nodes="$node->children" :active-cat="$activeCat" class="nested" />
        @endif
    </li>
@endforeach
</ul>
