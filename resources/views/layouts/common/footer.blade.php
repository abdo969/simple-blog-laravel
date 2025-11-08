<footer class="text-sm flex px-8 items-center border-t border-gray-100 flex-wrap justify-between py-4">
    <div>
        &copy; {{ date('Y') }} Blogz. All rights reserved.
    </div>
    <div class="space-x-4">
    <a class="text-gray-500 hover:text-yellow-500" href="{{ route('profile.show') }}">{{__('menu.profile')}}</a>
    <a class="text-gray-500 hover:text-yellow-500" href="{{ route('filament.admin.auth.login') }}">{{__('menu.login')}}</a>
    <a class="text-gray-500 hover:text-yellow-500" href="{{ route('posts.index') }}">{{__('menu.blog')}}</a>
    </div>
    <div>
        Powered by <a class="text-gray-500 hover:text-yellow-500" href="https://laravel.com/" target="_blank" rel="noopener noreferrer">Laravel</a> & <a class="text-gray-500 hover:text-yellow-500" href="https://filamentphp.com/" target="_blank" rel="noopener noreferrer">Filament</a>
    </div>
</footer>
