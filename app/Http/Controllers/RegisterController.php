<?php

namespace App\Http\Controllers;

use App\Models\Register;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function listRegister()
    {
        $registers = Register::orderBy('id', 'desc')->paginate(10);
        //dd('$registers');
        return view('listRegister', compact('registers'));
    }

    public function newRegister()
    {
        return view('newUser');
    }

    public function store(Request $request)
        {
            // Regras de validação e mensagens personalizadas
            $validatedData = $request->validate([
                'nome' => 'required|max:255',
                'email' => [
                    'required',
                    'email',
                    'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|com\.br|br)$/',
                    'max:255'
                ],
                'telefone' => [
                    'required',
                    'regex:/^\(?\d{2}\)?[\s-]?\d{4,5}[\s-]?\d{4}$/',
                    'max:15'
                ],
            ], [
                'nome.required' => 'Por favor, insira seu nome.',
                'nome.max' => 'O nome não pode ter mais de 255 caracteres.',
                'email.required' => 'Por favor, insira seu email.',
                'email.email' => 'Por favor, insira um email válido.',
                'email.regex' => 'Por favor, insira um email que termine em .com, .com.br ou .br.',
                'email.max' => 'O email não pode ter mais de 255 caracteres.',
                'telefone.required' => 'Por favor, insira seu telefone.',
                'telefone.regex' => 'Por favor, insira um telefone válido no formato (XX) XXXX-XXXX ou (XX) XXXXX-XXXX.',
                'telefone.max' => 'O telefone não pode ter mais de 15 caracteres.',
            ]);

            // Criação do registro no banco de dados
            try {
                $register = new Register($validatedData);
                $register->save();
        
                return response()->json([
                    'success' => true,
                    'message' => 'Registro criado com sucesso!'
                ]);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Ocorreu um erro ao criar o registro.'], 500);
            }
        }

    public function edit($id)
    {
        $register = Register::find($id);

        if (!$register) {
            return redirect()->route('registers.index')->with('error', 'Registro não encontrado.');
        }

        return view('editRegister', compact('register'));
    }

    public function update(Request $request, $id)
    {
        $register = Register::find($id);

        if (!$register) {
            return redirect()->route('registers.index')->with('error', 'Registro não encontrado.');
        }

        // Regras de validação e mensagens personalizadas
        $validatedData = $request->validate([
            'nome' => 'required|max:255',
            'email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|com\.br|br)$/',
                'max:255'
            ],
            'telefone' => [
                'required',
                'regex:/^\(?\d{2}\)?[\s-]?\d{4,5}[\s-]?\d{4}$/',
                'max:15'
            ],
        ], [
            'nome.required' => 'Por favor, insira seu nome.',
            'nome.max' => 'O nome não pode ter mais de 255 caracteres.',
            'email.required' => 'Por favor, insira seu email.',
            'email.email' => 'Por favor, insira um email válido.',
            'email.regex' => 'Por favor, insira um email que termine em .com, .com.br ou .br.',
            'email.max' => 'O email não pode ter mais de 255 caracteres.',
            'telefone.required' => 'Por favor, insira seu telefone.',
            'telefone.regex' => 'Por favor, insira um telefone válido no formato (XX) XXXX-XXXX ou (XX) XXXXX-XXXX.',
            'telefone.max' => 'O telefone não pode ter mais de 15 caracteres.',
        ]);

        // Atualiza o registro no banco de dados
        $register->update($validatedData);

        return redirect()->route('registers.index')->with('success', 'Registro atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $register = Register::find($id);

        if (!$register) {
            return response()->json(['error' => 'Registro não encontrado.'], 404);
        }

        $register->delete();
        return response()->json(['success' => 'Registro excluído com sucesso.']);
    }
}
