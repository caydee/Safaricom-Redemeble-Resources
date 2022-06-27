<footer class="footer w-100">
    <div class="container-fluid">
        <div class="row text-muted">
            <div class="col-6 text-left">
                <p class="mb-0">
                    &copy; <a href="{{ url('/') }}" class="text-muted">{{ $name }}</a>
                </p>
            </div>

        </div>
    </div>
</footer>
</div>
</div>

<script src="{{ asset('assets/js/app.js') }}" type="application/javascript"></script>
@yield('footer')
</body>

</html>
