  <form method="POST" action="{{ $action }}">
    @csrf

    <x-input name="username" type="text" label="Username"></x-input>
    <x-input name="password" type="password" label="Password"></x-input>
    @isset($redirect)
        <input type="hidden" name="redirect" value="{{ $redirect }}" />
    @endisset
    <x-input type="checkbox" name="remember" label="Remember me" />
    <x-button type="submit" class="button button--primary">
        Login
    </x-button>
</form>