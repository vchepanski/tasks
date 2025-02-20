<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Attachment;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        // Valida o arquivo (máximo de 2MB, ajuste se necessário)
        $request->validate([
            'attachment' => 'required|file|max:2048',
        ]);

        // Armazena o arquivo na pasta "attachments" no disco "public"
        $path = $request->file('attachment')->store('attachments', 'public');

        // Cria o registro do anexo no banco
        Attachment::create([
            'task_id' => $task->id,
            'user_id' => FacadesAuth::id(),
            'file_path' => $path,
        ]);

        return back()->with('success', 'Anexo enviado com sucesso!');
    }

    public function destroy(\App\Models\Attachment $attachment)
{
    // Verifica se o arquivo existe e remove do storage
    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($attachment->file_path)) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($attachment->file_path);
    }

    // Remove o registro do anexo do banco de dados
    $attachment->delete();

    return back()->with('success', 'Anexo removido com sucesso!');
}

}
