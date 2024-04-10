<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Libros;
use Database\Factories\LibroFactory;

class LibrosControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testCreate()
    {
        $imagen = UploadedFile::fake()->image('portada.jpg');
    
        $datosLibro = [
            'txtnombre' => $this->faker->sentence,
            'txtdescripcion' => $this->faker->paragraph,
            'portada' => $imagen,
            'txtautor' => $this->faker->name . ', ' . $this->faker->name,
        ];
    
        $response = $this->post(route('crud.create'), $datosLibro);
        
    
        $response->assertStatus(302);
    
        $this->assertDatabaseHas('libros', [
            'nombre' => $datosLibro['txtnombre'],
            'descripcion' => $datosLibro['txtdescripcion'],
        ]);
    }

    public function testlistar()
    {
        DB::table('libros')->insert([
            ['nombre' => 'libro 0', 'descripcion' => 'Descripción de la película 1', 'autor' => 'Autor 0, Autor 1'],
            ['nombre' => 'libro 1', 'descripcion' => 'Descripción de la película 2', 'autor' => 'Autor 2, Autor 3'],
        ]);

        $response = $this->get(route('crud.index'));

        $response->assertStatus(200);

        $response->assertSee('libro 0');
        $response->assertSee('libro 1');
    }

    public function testEliminar()
    {
        $libro = DB::table('libros')->insertGetId([
            'nombre' => 'libro de test',
            'descripcion' => 'Descripción del libro',
            'autor' => 'Autor 0, Autor 1',
        ]);

        $response = $this->get(route('crud.delete', $libro));

        $response->assertStatus(302);

        $this->assertDatabaseMissing('libros', ['id' => $libro]);
    }

    public function testActualizar()
    {
        $libro = DB::table('libros')->insertGetId([
            'nombre' => 'libro de test',
            'descripcion' => 'Descripción del libro',
            'autor' => 'Autor 0, Autor 1',
        ]);

        $imagen = UploadedFile::fake()->image('portadaactualizada.jpg');

        $Actualizado = [
            'txtnombre' => $this->faker->sentence,
            'txtdescripcion' => $this->faker->paragraph,
            'portada' => $imagen,
            'txtautor' => $this->faker->name . ', ' . $this->faker->name,
            'txtcodigo' => $libro,
        ];

        $response = $this->post(route('crud.update', $libro), $Actualizado);

        $response->assertStatus(302);

        $this->assertDatabaseHas('libros', [
            'id' => $libro,
            'nombre' => $Actualizado['txtnombre'],
            'descripcion' => $Actualizado['txtdescripcion'],
        ]);
    }

    public function testestres()
    {
        for ($i = 1; $i <= 100; $i++) {
            $imagen = UploadedFile::fake()->image('cartel' . $i . '.jpg');
        
            $datos = [
                'txtnombre' => $this->faker->sentence,
                'txtdescripcion' => $this->faker->paragraph,
                'portada' => $imagen,
                'txtautor' => $this->faker->name . ', ' . $this->faker->name,
            ];
        
            $response = $this->post(route('crud.create'), $datos);
            
            $response->assertStatus(302);
        
            $this->assertDatabaseHas('libros', [
                'nombre' => $datos['txtnombre'],
                'descripcion' => $datos['txtdescripcion'],
            ]);
        }
    }

    public function testbuscar()
    {
        DB::table('libros')->insert([
            ['nombre' => 'libro 0', 'descripcion' => 'Descripción 0', 'autor' => 'Autor 0'],
        ]);

        $response = $this->get(route('buscar', ['searchTerm' => 'libro 0']));

        $response->assertStatus(200);

        $response->assertSee('libro 0');
    }

}