<?php $_empty = true; ?>

<ul style="list-style-type: none;">
  @foreach($menu as $i => $root)
    @if(@$root['permissions']['allow'])
    <?php $_empty = false; ?>

    <li class="lh-2">
      <span class="module-name text-primary">{{ $root['name']}}</span>

      <ul class="submodule-list">
        @foreach($root['sub_modules'] as $j => $sub)
          @if(@$sub['permissions']['allow'])

          <li class="lh-1">{{ $sub['name'] }}</li>

          @endif
        @endforeach
      </ul>
    </li>

    @endif
  @endforeach

  @if($_empty)
    <li class="text-muted">No enabled modules.</li>
  @endif
</ul>
