// database/seeders/TodoSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Todo;

class TodoSeeder extends Seeder
{
    public function run()
    {
        Todo::create([
            'title' => 'Ngopi Kador',
            'is_done' => false,
        ]);

        Todo::create([
            'title' => 'Tempora Tempore Alias Velit Excepturi',
            'is_done' => false,
        ]);
    }
}
