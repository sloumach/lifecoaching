<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inbox') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">


                        <h2 class="mb-4">📬 Inbox - Messages reçus</h2>
                        <div class="card">
                            <div class="card-header">
                                <h5>📩 Liste des messages</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Nom</th>
                                            <th>Email</th>
                                            <th>Sujet</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($messages as $key => $message)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $message->name }}</td>
                                                <td>{{ $message->email }}</td>
                                                <td>{{ Str::limit($message->subject, 30) }}</td>
                                                <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#messageModal{{ $message->id }}">
                                                        Voir 📄
                                                    </button>
                                                    <form action="{{ route('admin.deleteMessage', $message->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                                                            Supprimer ❌
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            <!-- Modal pour voir le message -->
                                            <div class="modal fade" id="messageModal{{ $message->id }}" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">📨 Message de {{ $message->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Email:</strong> {{ $message->email }}</p>
                                                            <p><strong>Sujet:</strong> {{ $message->subject }}</p>
                                                            <hr>
                                                            <p><strong>Message:</strong></p>
                                                            <p>{{ $message->message }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>

                                @if($messages->isEmpty())
                                    <div class="alert alert-warning text-center">Aucun message reçu pour le moment 📭.</div>
                                @endif
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
