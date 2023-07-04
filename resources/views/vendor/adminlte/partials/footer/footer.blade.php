<footer class="main-footer">
    @yield('footer')
    <div class="text-center">
        Versão: {{ \Composer\InstalledVersions::getRootPackage()['pretty_version'] }}
    </div>
</footer>
