<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\M_libro;

class Libros extends Controller
{
    public function index()
    {
        $libro = new M_libro();
        $datos['libros'] = $libro->findAll();
        return view('libros', $datos);
    }

    public function agregar()
    {
        return view('agregar');
    }

    public function insertar()
    {
        $libro = new M_libro();

        $data = [
            'titulo' => $this->request->getPost('titulo'),
            'fecha_publicacion' => $this->request->getPost('fecha_publicacion'),
            'precio' => $this->request->getPost('precio'),
            'isbn' => $this->request->getPost('isbn')
        ];

        // Validar los datos recibidos
        if (!$this->validate([
            'titulo' => 'required',
            'fecha_publicacion' => 'required|valid_date',
            'precio' => 'required|decimal',
            'isbn' => 'required|alpha_numeric'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $libro->insert($data);
            return redirect()->to(base_url())->with('success', 'Libro agregado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function eliminar($id = null)
    {
        $libro = new M_libro();
        try {
            $libro->delete($id);
            return redirect()->to(base_url())->with('success', 'Libro eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function editar($id = null)
    {
        $libro = new M_libro();
        $registro['libros'] = $libro->find($id);
        return view('actualizando', $registro);
    }

    public function actualizar()
    {
        $libro = new M_libro();

        $id = $this->request->getPost('id');

        $data = [
            'titulo' => $this->request->getPost('titulo'),
            'fecha_publicacion' => $this->request->getPost('fecha_publicacion'),
            'precio' => $this->request->getPost('precio'),
            'isbn' => $this->request->getPost('isbn')
        ];

        // Validar los datos recibidos
        if (!$this->validate([
            'titulo' => 'required',
            'fecha_publicacion' => 'required|valid_date',
            'precio' => 'required|decimal',
            'isbn' => 'required|alpha_numeric'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $libro->update($id, $data);
            return redirect()->to(base_url())->with('success', 'Libro actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
