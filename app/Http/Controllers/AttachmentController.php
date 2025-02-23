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

  // Valida os arquivos (cada arquivo máximo de 2MB)
    $request->validate([
        'attachments'   => 'required|array',
        'attachments.*' => 'file|max:2048',
    ]);

    foreach ($request->file('attachments') as $file) {
        $path = $file->store('attachments', 'public');
        Attachment::create([
            'task_id'       => $task->id,
            'user_id'       => FacadesAuth::id(),
            'file_path'     => $path,
            'original_name' => $file->getClientOriginalName(), // opcional: armazena o nome original
        ]);
    }

    return back()->with('success', 'Anexo(s) enviado(s) com sucesso!');
}

    public function destroy(\App\Models\Attachment $attachment)
{
    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($attachment->file_path)) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($attachment->file_path);
    }

    // Remove o registro do anexo do banco de dados
    $attachment->delete();

    return back()->with('success', 'Anexo removido com sucesso!');
}

}
