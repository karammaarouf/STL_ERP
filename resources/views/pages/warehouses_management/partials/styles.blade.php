@push('styles')
    <style>
        /* Main Container */
        .locations-container {
            display: flex;
            gap: 1.25rem;
            padding: 1.5rem;
            height: calc(100vh - 200px);
            overflow-x: auto;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 0.5rem;
        }

        /* Column Styling */
        .location-column {
            flex: 1;
            min-width: 320px;
            max-width: 380px;
            display: flex;
            flex-direction: column;
            background: #ffffff;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .location-column:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        /* Column Header */
        .column-header {
            padding: 1.25rem;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-bottom: 2px solid #e9ecef;
            border-radius: 0.75rem 0.75rem 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .column-header h6 {
            font-size: 0.95rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
            display: flex;
            align-items: center;
        }

        /* Search Section */
        .column-search {
            padding: 1rem;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .column-search .input-group-text {
            background: #ffffff;
            border: 1px solid #dee2e6;
            color: #6c757d;
        }

        .column-search .form-control {
            background: #ffffff;
            border: 1px solid #dee2e6;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .column-search .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
            background: #ffffff;
        }

        /* Column Body */
        .column-body {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
            background: #ffffff;
            border-radius: 0 0 0.75rem 0.75rem;
        }

        /* List Items */
        .list-group-item {
            border: 1px solid #e9ecef;
            border-radius: 0.5rem;
            margin-bottom: 0.75rem;
            background: #ffffff;
            transition: all 0.3s ease;
            padding: 1rem;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .list-group-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, #007bff, #0056b3);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .list-group-item:hover {
            background: #f8f9fa;
            transform: translateX(4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-color: #007bff;
        }

        .list-group-item:hover::before {
            transform: scaleY(1);
        }

        .list-group-item.active {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-color: #2196f3;
            color: #1565c0;
            font-weight: 500;
        }

        .list-group-item.active::before {
            transform: scaleY(1);
            background: linear-gradient(135deg, #2196f3, #1976d2);
        }

        /* Item Content */
        .item-content {
            cursor: pointer;
        }

        .item-content h6 {
            color: #2c3e50;
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }

        .item-content small {
            color: #6c757d;
            font-size: 0.75rem;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.375rem;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .list-group-item:hover .action-buttons {
            opacity: 1;
        }

        .action-buttons .btn {
            padding: 0.375rem 0.5rem;
            font-size: 0.75rem;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
        }

        .action-buttons .btn:hover {
            transform: scale(1.1);
        }

        /* Loading and Empty States */
        .text-center {
            color: #6c757d;
        }

        .text-center i {
            opacity: 0.5;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .locations-container {
                gap: 1rem;
                padding: 1rem;
            }

            .location-column {
                min-width: 280px;
                max-width: 320px;
            }
        }

        @media (max-width: 768px) {
            .locations-container {
                flex-direction: column;
                height: auto;
                gap: 1rem;
            }

            .location-column {
                min-width: 100%;
                max-width: 100%;
                max-height: 400px;
            }
        }

        /* Custom Scrollbar */
        .column-body::-webkit-scrollbar,
        .locations-container::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .column-body::-webkit-scrollbar-track,
        .locations-container::-webkit-scrollbar-track {
            background: #f1f3f4;
            border-radius: 3px;
        }

        .column-body::-webkit-scrollbar-thumb,
        .locations-container::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #cbd5e1, #94a3b8);
            border-radius: 3px;
        }

        .column-body::-webkit-scrollbar-thumb:hover,
        .locations-container::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #94a3b8, #64748b);
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .loading {
            position: relative;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush