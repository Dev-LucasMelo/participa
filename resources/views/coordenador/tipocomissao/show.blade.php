@extends('coordenador.detalhesEvento')
@section('menu')
    <div id="divListarComissoes"
        style="display: block">
        @include('componentes.mensagens')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="titulo-detalhes">Listagem dos membros da comissão {{ $comissao->nome }}</h1>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-9">
                                <h5 class="card-title">Membros</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Membros cadastrados na comissão</h6>
                            </div>
                            <div class="col-sm-3"
                                style="text-align: right;">
                                <button class="btn btn-primary"
                                    data-toggle="modal"
                                    data-target="#modalCadastrarMembro">+ Cadastrar membro</button>
                            </div>
                        </div>
                        <p class="card-text">
                        <table class="table table-hover table-responsive-lg table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Nome</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col"
                                        style="text-align:center">Remover</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($comissao->membros as $membro)
                                    <tr>
                                        <td data-toggle="modal"
                                            data-target="#modalEditarMembro{{ $membro->id }}">{{ $membro->name }}</td>
                                        <td data-toggle="modal"
                                            data-target="#modalEditarMembro{{ $membro->id }}">{{ $membro->email }}</td>
                                        <td style="text-align:center">
                                            <form id="removerMembro{{ $membro->id }}"
                                                action="{{ route('coord.tipocomissao.removermembro', ['evento' => $evento, 'comissao' => $comissao]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="email" value="{{$membro->email}}">
                                                <a href="#"
                                                    data-toggle="modal"
                                                    data-target="#modalRemoverMembro{{ $membro->id }}">
                                                    <img src="{{ asset('img/icons/user-times-solid.svg') }}"
                                                        class="icon-card"
                                                        style="width:25px">
                                                </a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach ($comissao->membros as $membro)
        <!-- Modal de exclusão do membro -->
        <div class="modal fade"
            id="modalRemoverMembro{{ $membro->id }}"
            tabindex="-1"
            role="dialog"
            aria-labelledby="#label"
            aria-hidden="true">
            <div class="modal-dialog"
                role="document">
                <div class="modal-content">
                    <div class="modal-header"
                        style="background-color: #114048ff; color: white;">
                        <h5 class="modal-title"
                            id="#label">Confirmação</h5>
                        <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                            style="color: white;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Tem certeza que deseja remover o membro com email {{$membro->email}} da comissão?
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">Não</button>
                        <button type="submit"
                            class="btn btn-primary"
                            form="removerMembro{{ $membro->id }}">Sim</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- cadastrar membro -->
    <div class="modal fade"
        id="modalCadastrarMembro"
        tabindex="-1"
        role="dialog"
        aria-labelledby="modalCadastrarMembroLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md"
            role="document">
            <div class="modal-content">
                <div class="modal-header"
                    style="background-color: #114048ff; color: white;">
                    <h5 class="modal-title"
                        id="modalCadastrarMembroLabel">Cadastrar um novo membro comissao</h5>
                    <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                        style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="cadastrarMembroForm"
                        method="POST"
                        action="{{ route('coord.tipocomissao.addmembro', ['evento' => $evento, 'comissao' => $comissao]) }}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="email"
                                    class="col-form-label">{{ __('Email') }}</label>
                                <input id="email"
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                    autofocus
                                    placeholder="Email do novo membro">

                                @error('email')
                                    <span class="invalid-feedback"
                                        role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">Cancelar</button>
                    <button type="submit"
                        class="btn btn-primary"
                        form="cadastrarMembroForm">{{ __('Finalizar') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
