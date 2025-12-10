@extends('layouts.app')

@section('title', 'Gestión de Equipo')

@section('content')

<div class="admin-equipo-page">
    <div class="container-equipo">
        
        {{-- Back Link - Va al evento si existe, si no a la lista de equipos --}}
        @if($evento)
            <a href="{{ route('admin.eventos.show', $evento) }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Volver al Evento
            </a>
        @else
            <a href="{{ route('admin.equipos.index') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Volver a Equipos
            </a>
        @endif

        {{-- Alerta de Jurados Insuficientes --}}
        @if($evento && !$juradosSuficientes)
        <div class="alert-jurados" id="alertJurados">
            <div class="alert-content">
                <div class="alert-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="alert-text">
                    <strong>⚠️ Atención: Jurados Insuficientes</strong>
                    <p>
                        El evento <strong>{{ $evento->nombre }}</strong> tiene 
                        <span class="jurado-count">{{ $juradosCount }} jurado(s)</span> asignado(s).
                        Se requieren entre <strong>3 y 5 jurados</strong> para poder gestionar proyectos.
                    </p>
                    <a href="{{ route('admin.eventos.show', $evento) }}" class="alert-link">
                        <i class="fas fa-user-tie"></i> Ir a Gestionar Jurados del Evento
                    </a>
                </div>
                <button class="alert-close" onclick="closeAlert()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="alert-progress" id="alertProgress"></div>
        </div>
        @endif

        {{-- Header del Equipo --}}
        <div class="team-hero">
            <div class="hero-image">
                @if ($equipo->ruta_imagen)
                    <img src="{{ asset('storage/' . $equipo->ruta_imagen) }}" alt="{{ $equipo->nombre }}">
                @else
                    <div class="hero-placeholder">
                        <i class="fas fa-users"></i>
                    </div>
                @endif
            </div>
            <div class="hero-info">
                <h1>{{ $equipo->nombre }}</h1>
                <div class="hero-badges">
                    <span class="badge-members">
                        <i class="fas fa-user-friends"></i>
                        {{ $equipo->miembros->count() }}/5 Miembros
                    </span>
                    @if($equipo->miembros->count() >= 5)
                        <span class="badge-complete"><i class="fas fa-check-circle"></i> Completo</span>
                    @else
                        <span class="badge-incomplete"><i class="fas fa-clock"></i> Incompleto</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Información del Evento (con fechas llamativas) --}}
        @if($evento)
        <div class="event-card">
            <div class="event-header">
                <i class="fas fa-calendar-star"></i>
                <span>Evento Inscrito</span>
            </div>
            <div class="event-body">
                <div class="event-name">
                    <a href="{{ route('admin.eventos.show', $evento) }}">{{ $evento->nombre }}</a>
                </div>
                <div class="event-dates">
                    <div class="date-box start">
                        <div class="date-label">INICIO</div>
                        <div class="date-day">{{ $evento->fecha_inicio->format('d') }}</div>
                        <div class="date-month">{{ $evento->fecha_inicio->translatedFormat('M Y') }}</div>
                    </div>
                    <div class="date-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    <div class="date-box end">
                        <div class="date-label">FIN</div>
                        <div class="date-day">{{ $evento->fecha_fin->format('d') }}</div>
                        <div class="date-month">{{ $evento->fecha_fin->translatedFormat('M Y') }}</div>
                    </div>
                </div>
                <div class="event-meta">
                    <span class="meta-item">
                        <i class="fas fa-user-tie"></i>
                        {{ $juradosCount }} Jurado(s)
                        @if($juradosSuficientes)
                            <i class="fas fa-check text-green-500"></i>
                        @else
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                        @endif
                    </span>
                    <span class="meta-item estado-{{ strtolower($evento->estado) }}">
                        <i class="fas fa-circle"></i>
                        {{ $evento->estado }}
                    </span>
                </div>
            </div>
        </div>
        @else
        <div class="no-event-card">
            <i class="fas fa-calendar-times"></i>
            <p>Este equipo no está inscrito en ningún evento</p>
        </div>
        @endif

        {{-- Miembros del Equipo --}}
        <div class="section-card">
            <div class="section-header">
                <h3><i class="fas fa-users"></i> Miembros del Equipo</h3>
                <span class="member-counter">{{ $equipo->miembros->count() }}/5</span>
            </div>
            <div class="members-list">
                @forelse($equipo->miembros as $miembro)
                    <div class="member-row {{ $miembro->es_lider ? 'is-leader' : '' }}">
                        <div class="member-info">
                            <div class="member-avatar {{ $miembro->es_lider ? 'leader-border' : '' }}">
                                <img src="{{ $miembro->user->foto_perfil_url }}" alt="{{ $miembro->user->nombre }}">
                                @if($miembro->es_lider)
                                    <span class="leader-crown"><i class="fas fa-crown"></i></span>
                                @endif
                            </div>
                            <div class="member-details">
                                <h4>{{ $miembro->user->nombre_completo }}</h4>
                                <p>{{ optional($miembro->user->estudiante)->carrera->nombre ?? 'Sin carrera' }}</p>
                            </div>
                        </div>
                        <div class="member-actions">
                            {{-- Cambiar Rol (solo para no-líderes) --}}
                            @if(!$miembro->es_lider)
                            <form action="{{ route('admin.miembros.update-role', $miembro) }}" method="POST" class="role-form">
                                @csrf
                                @method('PATCH')
                                <select name="id_rol_equipo" class="role-select">
                                    @foreach($roles as $rol)
                                        @if($rol->nombre !== 'Líder')
                                            <option value="{{ $rol->id_rol_equipo }}" @selected($rol->id_rol_equipo == $miembro->id_rol_equipo)>
                                                {{ $rol->nombre }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                <button type="submit" class="btn-sm btn-update">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </form>
                            @endif

                            @if($miembro->es_lider)
                                <span class="badge-leader"><i class="fas fa-crown"></i> Líder</span>
                            @else
                                <form action="{{ route('admin.miembros.toggle-leader', $miembro) }}" method="POST" 
                                      onsubmit="return confirm('¿Hacer a este miembro el nuevo líder?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-sm btn-make-leader">
                                        <i class="fas fa-crown"></i>
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('admin.miembros.destroy', $miembro) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar a este miembro del equipo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-remove">
                                    <i class="fas fa-user-minus"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="empty-members">
                        <i class="fas fa-users-slash"></i>
                        <p>No hay miembros en este equipo</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Acciones de Administrador --}}
        <div class="section-card actions-card">
            <div class="section-header">
                <h3><i class="fas fa-cogs"></i> Acciones de Administrador</h3>
            </div>
            <div class="actions-grid">
                <a href="{{ route('admin.equipos.edit', $equipo) }}" class="action-btn edit">
                    <i class="fas fa-edit"></i>
                    <span>Editar Equipo</span>
                </a>

                @if($inscripcion = $equipo->inscripciones->first())
                    <form action="{{ route('admin.equipos.remove-from-event', $equipo) }}" method="POST"
                          onsubmit="return confirm('¿Excluir este equipo del evento? El equipo no se eliminará.');">
                        @csrf
                        <input type="hidden" name="evento_id" value="{{ $inscripcion->id_evento }}">
                        <button type="submit" class="action-btn exclude">
                            <i class="fas fa-calendar-minus"></i>
                            <span>Excluir del Evento</span>
                        </button>
                    </form>
                @endif

                <form action="{{ route('admin.equipos.destroy', $equipo) }}" method="POST"
                      onsubmit="return confirm('⚠️ ACCIÓN IRREVERSIBLE: ¿Eliminar este equipo completamente?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-btn delete">
                        <i class="fas fa-trash-alt"></i>
                        <span>Eliminar Equipo</span>
                    </button>
                </form>

                {{-- Botón Transferir Liderazgo --}}
                @if($equipo->miembros->count() > 1)
                    <button type="button" onclick="openTransferModal()" class="action-btn transfer">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Transferir Liderazgo</span>
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal de Transferencia de Liderazgo --}}
@if($equipo->miembros->count() > 1)
<div id="transferModal" class="transfer-modal hidden">
    <div class="transfer-modal-overlay" onclick="closeTransferModal()"></div>
    <div class="transfer-modal-content">
        <div class="transfer-modal-header">
            <h3>
                <i class="fas fa-exchange-alt"></i>
                Transferir Liderazgo
            </h3>
            <button type="button" onclick="closeTransferModal()" class="modal-close-btn">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="transfer-modal-body">
            <p class="transfer-info">
                <i class="fas fa-info-circle"></i>
                <span>Selecciona al nuevo líder del equipo. El líder actual pasará a ser un miembro regular.</span>
            </p>
            <h4>Miembros disponibles:</h4>
            <div class="transfer-members-list">
                @foreach($equipo->miembros as $miembro)
                    @if(!$miembro->es_lider)
                        <form action="{{ route('admin.miembros.toggle-leader', $miembro) }}" method="POST" class="transfer-member-form">
                            @csrf
                            @method('PATCH')
                            <div class="transfer-member-item">
                                <div class="transfer-member-info">
                                    <div class="transfer-avatar">
                                        <img src="{{ $miembro->user->foto_perfil_url }}" alt="{{ $miembro->user->nombre }}">
                                    </div>
                                    <div class="transfer-details">
                                        <span class="transfer-name">{{ $miembro->user->nombre_completo }}</span>
                                        <span class="transfer-role">{{ $miembro->rol->nombre ?? 'Sin rol' }}</span>
                                    </div>
                                </div>
                                <button type="submit" class="transfer-select-btn" onclick="return confirm('¿Hacer a {{ $miembro->user->nombre }} el nuevo líder?')">
                                    <i class="fas fa-crown"></i> Hacer Líder
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="transfer-member-item current-leader">
                            <div class="transfer-member-info">
                                <div class="transfer-avatar">
                                    <img src="{{ $miembro->user->foto_perfil_url }}" alt="{{ $miembro->user->nombre }}">
                                </div>
                                <div class="transfer-details">
                                    <span class="transfer-name">{{ $miembro->user->nombre_completo }}</span>
                                    <span class="transfer-role">{{ $miembro->rol->nombre ?? 'Sin rol' }}</span>
                                </div>
                            </div>
                            <span class="current-leader-badge">
                                <i class="fas fa-crown"></i> Líder Actual
                            </span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="transfer-modal-footer">
            <button type="button" onclick="closeTransferModal()" class="btn-cancel-transfer">
                Cancelar
            </button>
        </div>
    </div>
</div>

<style>
/* Modal de Transferencia */
.transfer-modal {
    position: fixed;
    inset: 0;
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}
.transfer-modal.hidden {
    display: none;
}
.transfer-modal-overlay {
    position: absolute;
    inset: 0;
    background: rgba(15, 23, 42, 0.7);
    backdrop-filter: blur(4px);
}
.transfer-modal-content {
    position: relative;
    background: white;
    border-radius: 16px;
    width: 100%;
    max-width: 500px;
    max-height: 90vh;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: modalSlideIn 0.3s ease-out;
}
@keyframes modalSlideIn {
    from { opacity: 0; transform: translateY(-20px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
.transfer-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem 1.5rem;
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    color: white;
}
.transfer-modal-header h3 {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    font-size: 1.1rem;
    font-weight: 700;
    margin: 0;
}
.modal-close-btn {
    background: rgba(255,255,255,0.2);
    border: none;
    color: white;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
}
.modal-close-btn:hover {
    background: rgba(255,255,255,0.3);
}
.transfer-modal-body {
    padding: 1.25rem 1.5rem;
    max-height: 450px;
    overflow-y: auto;
}
.transfer-info {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 0.875rem 1rem;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 10px;
    margin-bottom: 1.25rem;
    font-size: 0.85rem;
    color: #1e40af;
}
.transfer-info i {
    flex-shrink: 0;
    margin-top: 0.1rem;
}
.transfer-modal-body h4 {
    font-size: 0.9rem;
    font-weight: 600;
    color: #374151;
    margin: 0 0 0.75rem 0;
}
.transfer-members-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}
.transfer-member-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.875rem 1rem;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    transition: all 0.2s;
}
.transfer-member-item:hover:not(.current-leader) {
    border-color: #3b82f6;
    background: #eff6ff;
}
.transfer-member-item.current-leader {
    background: linear-gradient(135deg, #fef3c7, #fefce8);
    border-color: #fcd34d;
}
.transfer-member-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.transfer-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid #e2e8f0;
}
.transfer-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.transfer-details {
    display: flex;
    flex-direction: column;
}
.transfer-name {
    font-weight: 600;
    color: #0f172a;
    font-size: 0.9rem;
}
.transfer-role {
    font-size: 0.75rem;
    color: #64748b;
}
.transfer-select-btn {
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.4rem;
    transition: all 0.2s;
}
.transfer-select-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);
}
.current-leader-badge {
    background: linear-gradient(135deg, #f59e0b, #fbbf24);
    color: white;
    padding: 0.4rem 0.85rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.35rem;
}
.transfer-modal-footer {
    padding: 1rem 1.5rem;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    display: flex;
    justify-content: flex-end;
}
.btn-cancel-transfer {
    background: #e2e8f0;
    color: #475569;
    border: none;
    padding: 0.6rem 1.25rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-cancel-transfer:hover {
    background: #cbd5e1;
}

/* Botón de transferir en grid de acciones */
.action-btn.transfer {
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    color: white;
    width: 100%;
}
.action-btn.transfer:hover {
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.35);
}
</style>
@endif

<script>
    // Auto-cerrar alerta de jurados después de 8 segundos
    const alertJurados = document.getElementById('alertJurados');
    const alertProgress = document.getElementById('alertProgress');
    
    if (alertJurados) {
        alertProgress.style.animation = 'progress 8s linear forwards';
        
        setTimeout(() => {
            alertJurados.classList.add('hiding');
            setTimeout(() => {
                alertJurados.style.display = 'none';
            }, 500);
        }, 8000);
    }
    
    function closeAlert() {
        const alert = document.getElementById('alertJurados');
        if (alert) {
            alert.classList.add('hiding');
            setTimeout(() => {
                alert.style.display = 'none';
            }, 500);
        }
    }

    // Modal de transferencia de liderazgo
    function openTransferModal() {
        const modal = document.getElementById('transferModal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeTransferModal() {
        const modal = document.getElementById('transferModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }

    // Cerrar con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeTransferModal();
        }
    });
</script>

@endsection