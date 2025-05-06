public function boot(): void
{
    Paginator::useTailwind();

    Gate::define('admin', function ($user) {
        return $user->is_admin == true;
    });
}