---
title: Kretmann & Roskarniz — ER Schema
config:
    layout: elk
    theme: dark
---
erDiagram
    categories {
        int id PK
        string name
        string slug UK
        text description
        string image
        string system_code
        int sort_order
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    products {
        int id PK
        int category_id FK
        string name
        string slug UK
        text description
        text short_description
        string image
        string system_code
        string accent_color
        int sort_order
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    profiles {
        int id PK
        string name
        string slug UK
        text description
        string image
        int max_span_mm
        json tags
        boolean is_best_seller
        int sort_order
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    materials {
        int id PK
        string name
        string slug UK
        string hex_color
        text description
        string image
        int sort_order
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    automation_options {
        int id PK
        string name
        string slug UK
        text description
        string subtitle
        string icon
        int sort_order
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    configurations {
        int id PK
        int profile_id FK
        int width_mm
        int height_mm
        int material_id FK
        string session_token
        timestamp created_at
        timestamp updated_at
    }

    configuration_automation {
        int id PK
        int configuration_id FK
        int automation_option_id FK
        boolean is_enabled
        timestamp created_at
        timestamp updated_at
    }

    orders {
        int id PK
        int configuration_id FK
        string client_name
        string client_phone
        string status
        text admin_note
        timestamp created_at
        timestamp updated_at
    }

    categories ||--o{ products : "has"
    profiles ||--o{ configurations : "selected in"
    materials ||--o{ configurations : "selected in"
    configurations ||--o{ configuration_automation : "has"
    automation_options ||--o{ configuration_automation : "linked via"
    configurations ||--o{ orders : "ordered with"
