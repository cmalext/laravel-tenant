@extends('layout')

@section('content')
<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">


    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

       
        <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">
                            Tenant Loaded
                        </div>
                    </div>

                    <div class="ml-12">
                        <div class="mt-2 text-gray-900 dark:text-white text-sm">
                            <pre>
                            @php 
                            print_r((resolve('ts'))->tenant());
                            @endphp
                            </pre>
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                    <div class="flex items-center">
                        <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">
                            Getting Tenant Data
                        </div>
                    </div>

                    <div class="ml-12">
                        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">

                            <ul>
                                <li>
                                    <code class="text-gray-900 dark:text-white">config('app.name')</code> // upon tenant creation, the app name becomes the Tenant name unless otherwise updated
                                </li>

                                <li>
                                    <code class="text-gray-900 dark:text-white">$tname</code> // is the Tenant name shared to views (<code class="text-gray-900 dark:text-white">$tid && $tcode</code> are also available for the id and code)
                                </li>

                                <li>
                                    <code class="text-gray-900 dark:text-white">(resolve('ts'))->tenant()</code> // is also available for any parts of the application which returns an object representation of App\Models\Tenant::class currently loaded
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">
                            Understanding Tenant Config
                        </div>
                    </div>

                    <div class="ml-12">
                        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                            <code class="text-gray-900 dark:text-white">/config/tenants/{tenant->code}.php</code> // is the tenant's config file.
                            This will override any of the base config. <br> For example. if you have
                            <code class="text-gray-900 dark:text-white">/config/app.php</code>
                            <pre class="text-gray-900 dark:text-white"> @php print_r(['name' => 'Laravel']) @endphp </pre>
                            You can override it in tenant by adding the adding this on the tenant's config
                            <pre class="text-gray-900 dark:text-white"> @php print_r(['app' => ['name' => 'Youtube']]) @endphp </pre>
                            Therefore <code class="text-gray-900 dark:text-white">config('app.name')</code> gives you <code class="text-gray-900 dark:text-white">Youtube</code> if you are on loading this tenant
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-l">
                    <div class="flex items-center">
                        <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">
                            Loading Tenant
                        </div>
                    </div>

                    <div class="ml-12">
                        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                            Loading a Tenant by default will be based on the domain the app is being accessed.
                            <br><br>
                            If you go to the tenant's config file <code class="text-gray-900 dark:text-white">/config/tenants/{tenant->code}.php</code>
                            Notice there is <code class="text-gray-900 dark:text-white">app.domains</code>
                            <pre class="text-gray-900 dark:text-white">
                            @php
                            print_r(['app' => ['name' => '.....', 'domains' => ['http://youtube.test']]])
                            @endphp
                            </pre>

                            This is where we refer what tenant to be loaded. If you accessed the app using <code class="text-gray-900 dark:text-white">http://youtube.test</code>, that
                            means you are loading the tenant above. Also notice that <code class="text-gray-900 dark:text-white">domains is an array</code>, so you can add more domains for this tenant to be loaded. <code class="text-gray-900 dark:text-white">(example: youtube.com = production, youtube.test = local)</code>

                            <br><br>
                            Loading specific tenant is console is tricky since we can no longer rely on the domain.
                            This is where <code class="text-gray-900 dark:text-white">forceTenant</code> method becomes handy.
                            <code class="text-gray-900 dark:text-white">\App\Providers\TenantServiceProvider::forceTenant(code);</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
            <div class="text-center text-sm text-gray-500 sm:text-left">
                <div class="flex items-center">
                    <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="-mt-px w-5 h-5 text-gray-400">
                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>

                    <a href="https://laravel.bigcartel.com" class="ml-1 underline">
                        Shop
                    </a>

                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="ml-4 -mt-px w-5 h-5 text-gray-400">
                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>

                    <a href="https://github.com/sponsors/taylorotwell" class="ml-1 underline">
                        Sponsor
                    </a>
                </div>
            </div>

            <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </div>
        </div>
    </div>
</div>
@endsection