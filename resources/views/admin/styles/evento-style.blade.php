{{-- resources/views/partials/evento-styles.blade.php --}}
<style>
    /* Modal para Agregar/Editar Evento */
    .event-modal .modal-dialog {
        max-width: 700px;
    }
    
    .event-modal .modal-content {
        border-radius: 15px;
        border: none;
        overflow: hidden;
    }
    
    .event-modal .modal-header {
        background-color: var(--primary-color);
        color: white;
        border-bottom: none;
        padding: 25px 30px;
    }
    
    .event-modal .modal-title {
        font-weight: 700;
        font-size: 1.5rem;
    }
    
    .event-modal .modal-body {
        padding: 30px;
    }
    
    .event-modal .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }
    
    .event-modal .form-control,
    .event-modal .form-select {
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 10px 15px;
        transition: border-color 0.3s;
    }
    
    .event-modal .form-control:focus,
    .event-modal .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    
    .textarea-container {
        position: relative;
    }
    
    .textarea-container textarea {
        resize: vertical;
        min-height: 120px;
    }
    
    .image-upload-container {
        border: 2px dashed #ccc;
        border-radius: 10px;
        padding: 40px 20px;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.3s, background-color 0.3s;
        margin-top: 20px;
    }
    
    .image-upload-container:hover {
        border-color: var(--primary-color);
        background-color: rgba(13, 110, 253, 0.05);
    }
    
    .image-upload-icon {
        font-size: 3rem;
        color: var(--secondary-color);
        margin-bottom: 15px;
    }
    
    .image-upload-text {
        color: var(--secondary-color);
        font-weight: 500;
        margin-bottom: 5px;
    }
    
    .image-upload-subtext {
        color: #999;
        font-size: 0.9rem;
    }
    
    .image-preview {
        max-width: 100%;
        max-height: 200px;
        margin-top: 15px;
        border-radius: 8px;
        display: none;
    }
    
    .tec-footer {
        text-align: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
        color: var(--primary-color);
        font-weight: 600;
    }
    
    .modal-footer {
        border-top: none;
        padding: 25px 30px;
        gap: 15px;
    }
    
    .btn-modal-cancel {
        background-color: #6c757d;
        color: white;
        padding: 10px 30px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
    }
    
    .btn-modal-save {
        background-color: var(--primary-color);
        color: white;
        padding: 10px 30px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
    }
    
    .btn-modal-cancel:hover {
        background-color: #5a6268;
    }
    
    .btn-modal-save:hover {
        background-color: #0b5ed7;
    }
    
    @media (max-width: 768px) {
        .event-modal .modal-dialog {
            margin: 10px;
        }
    }
    
    @media (max-width: 576px) {
        .event-modal .modal-body {
            padding: 20px;
        }
    }
</style>