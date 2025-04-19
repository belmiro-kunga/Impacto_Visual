@extends('admin.layouts.app')

@section('title', 'Configurações do Site')
@section('page_title', 'Configurações do Site')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Categorias</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        @foreach($groups as $key => $label)
                            <li class="nav-item">
                                <a href="{{ route('admin.settings.index', $key) }}" class="nav-link {{ $group == $key ? 'active' : '' }}">
                                    <i class="bi {{ $key == 'general' ? 'bi-gear' : ($key == 'contact' ? 'bi-envelope' : ($key == 'social' ? 'bi-people' : 'bi-envelope-paper')) }} me-2"></i>
                                    {{ $label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $groups[$group] ?? 'Configurações' }}</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.settings.update', $group) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        @foreach($settings as $setting)
                            <div class="form-group mb-3">
                                <label for="{{ $setting->key }}">{{ $setting->label }}</label>
                                
                                @if($setting->type == 'text' || $setting->type == 'email' || $setting->type == 'url' || $setting->type == 'number')
                                    <input type="{{ $setting->type }}" 
                                           name="settings[{{ $setting->key }}]" 
                                           id="{{ $setting->key }}" 
                                           class="form-control"
                                           value="{{ old('settings.' . $setting->key, $setting->value) }}">
                                
                                @elseif($setting->type == 'textarea')
                                    <textarea name="settings[{{ $setting->key }}]" 
                                              id="{{ $setting->key }}" 
                                              class="form-control" 
                                              rows="3">{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                                
                                @elseif($setting->type == 'select')
                                    <select name="settings[{{ $setting->key }}]" 
                                            id="{{ $setting->key }}" 
                                            class="form-control">
                                        @foreach(json_decode($setting->options, true) as $value => $label)
                                            <option value="{{ $value }}" {{ $setting->value == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                
                                @elseif($setting->type == 'file')
                                    <div class="input-group">
                                        <input type="file" 
                                               name="settings[{{ $setting->key }}]" 
                                               id="{{ $setting->key }}" 
                                               class="form-control">
                                    </div>
                                    
                                    @if($setting->value)
                                        <div class="mt-2">
                                            @if(in_array(pathinfo($setting->value, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'ico']))
                                                <img src="{{ asset($setting->value) }}" alt="{{ $setting->label }}" class="img-thumbnail" style="max-height: 100px;">
                                            @else
                                                <span class="badge bg-info">{{ pathinfo($setting->value, PATHINFO_BASENAME) }}</span>
                                            @endif
                                        </div>
                                    @endif
                                
                                @elseif($setting->type == 'password')
                                    <input type="password" 
                                           name="settings[{{ $setting->key }}]" 
                                           id="{{ $setting->key }}" 
                                           class="form-control"
                                           placeholder="{{ $setting->value ? '••••••••' : '' }}">
                                    @if($setting->value)
                                        <small class="form-text text-muted">Deixe em branco para manter a senha atual</small>
                                    @endif
                                @endif
                            </div>
                        @endforeach
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Salvar Configurações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 