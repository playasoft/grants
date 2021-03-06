<div class="form-group {{ ($errors->has($name)) ? 'has-error' : '' }}">
    <label class="control-label" for="{{ $name }}-field">{{ $label }}</label>
    <span class="pull-right"><span class="status"></span></span>

    @yield('html')

    @if($errors->has($name))
        <span class="help-block">{{ $errors->first($name) }}</span>
    @elseif(isset($help))
        <span class="help-block">{{ $help }}</span>
    @endif
</div>
