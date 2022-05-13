<footer class="text-gray-600 body-font">
    <div class="container px-5 py-8 mx-auto flex items-center sm:flex-row flex-col justify-center">
        <a class="flex title-font font-medium items-center md:justify-start justify-center text-gray-900">
            <img src="https://laravel.com/img/logomark.min.svg" alt="footer_image">
        </a>
        <p class="text-sm text-gray-500 sm:ml-4 sm:pl-4 sm:border-l-2 sm:border-gray-200 sm:py-2 sm:mt-0 mt-4">
            © {{ now()->year }} {{ config('app.name', 'Laravel') }}
        </p>
    </div>
</footer>
