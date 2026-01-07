# Laravel Passport API Documentation

## Base URL
```
http://localhost:8100/api
```

## Authentication
All protected endpoints require a Bearer token in the Authorization header:
```
Authorization: Bearer {your_access_token}
```

---

## 🔐 Authentication Endpoints

### 1. Login (Get Access Token)
**Endpoint:** `POST /api/login`  
**Authentication:** None (Public)  
**Description:** Login with email/password and get access token

**Request Headers:**
```
Content-Type: application/json
```

**Request Body:**
```json
{
  "email": "admin@test.com",
  "password": "password"
}
```

**Response (200 OK):**
```json
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "user": {
    "id": 2,
    "name": "Admin User",
    "email": "admin@test.com",
    "roles": [
      {
        "id": 1,
        "name": "admin",
        "description": "Administrator"
      }
    ]
  }
}
```

**Test Users:**
- `admin@test.com` / `password` (admin role)
- `manager@test.com` / `password` (manager role)
- `staff1@test.com` / `password` (staff role)
- `staff2@test.com` / `password` (staff role)

---

### 2. Get Current User
**Endpoint:** `GET /api/me`  
**Authentication:** Required (Bearer Token)  
**Description:** Get authenticated user info with roles and permissions

**Request Headers:**
```
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "id": 2,
  "name": "Admin User",
  "email": "admin@test.com",
  "email_verified_at": null,
  "created_at": "2026-01-07T03:19:38.000000Z",
  "updated_at": "2026-01-07T03:19:38.000000Z",
  "roles": [
    {
      "id": 1,
      "name": "admin",
      "description": "Administrator",
      "permissions": [
        {
          "id": 1,
          "name": "manage_products",
          "description": "Can manage products"
        },
        {
          "id": 2,
          "name": "manage_categories",
          "description": "Can manage categories"
        }
      ]
    }
  ]
}
```

---

## 📦 Product Endpoints

### 3. Get All Products
**Endpoint:** `GET /api/products`  
**Authentication:** Required  
**Description:** List all products

**Request Headers:**
```
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
[
  {
    "id": 1,
    "name": "Test Product",
    "category_id": 1,
    "pricing": 99.99,
    "description": "Sample product",
    "images": "http://example.com/img.jpg",
    "created_by": 2,
    "created_at": "2026-01-07T06:30:47.000000Z",
    "updated_at": "2026-01-07T06:30:47.000000Z"
  }
]
```

---

### 4. Create Product (Manager/Admin Only)
**Endpoint:** `POST /api/products`  
**Authentication:** Required (Manager or Admin role)  
**Description:** Create a new product

**Request Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "name": "Test Product",
  "category_id": 1,
  "pricing": 99.99,
  "description": "Sample product",
  "images": "http://example.com/img.jpg"
}
```

**Validation Rules:**
- `name`: required, string, max 255 characters
- `category_id`: required, integer, must exist in categories table
- `pricing`: required, numeric
- `description`: optional, string
- `images`: optional, string

**Response (201 Created):**
```json
{
  "id": 1,
  "name": "Test Product",
  "category_id": 1,
  "pricing": 99.99,
  "description": "Sample product",
  "images": "http://example.com/img.jpg",
  "created_by": 2,
  "created_at": "2026-01-07T06:30:47.000000Z",
  "updated_at": "2026-01-07T06:30:47.000000Z"
}
```

**Error Response (403 Forbidden):**
```json
{
  "message": "Only managers and admins can create products"
}
```

---

### 5. Get Product by ID
**Endpoint:** `GET /api/products/{id}`  
**Authentication:** Required  
**Description:** Get a specific product by ID

**Request Headers:**
```
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "id": 1,
  "name": "Test Product",
  "category_id": 1,
  "pricing": 99.99,
  "description": "Sample product",
  "images": "http://example.com/img.jpg",
  "created_by": 2,
  "created_at": "2026-01-07T06:30:47.000000Z",
  "updated_at": "2026-01-07T06:30:47.000000Z"
}
```

---

### 6. Update Product
**Endpoint:** `PATCH /api/products/{id}`  
**Authentication:** Required (Policy-based)  
**Description:** Update a product

**Request Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "name": "Updated Product Name",
  "pricing": 149.99
}
```

**Validation Rules:**
- `name`: optional, string, max 255 characters
- `category_id`: optional, integer, must exist in categories table
- `pricing`: optional, numeric
- `description`: optional, string
- `images`: optional, string

**Response (200 OK):**
```json
{
  "id": 1,
  "name": "Updated Product Name",
  "category_id": 1,
  "pricing": 149.99,
  "description": "Sample product",
  "images": "http://example.com/img.jpg",
  "created_by": 2,
  "created_at": "2026-01-07T06:30:47.000000Z",
  "updated_at": "2026-01-07T07:15:22.000000Z"
}
```

---

### 7. Delete Product
**Endpoint:** `DELETE /api/products/{id}`  
**Authentication:** Required (Policy-based)  
**Description:** Delete a product

**Request Headers:**
```
Authorization: Bearer {token}
```

**Response (204 No Content)**

---

## 📁 Category Endpoints

### 8. Get All Categories
**Endpoint:** `GET /api/categories`  
**Authentication:** Required  
**Description:** List all categories

**Request Headers:**
```
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
[
  {
    "id": 1,
    "name": "Electronics",
    "description": "Electronic devices",
    "parent_category_id": null,
    "status": "active",
    "created_at": "2026-01-07T03:19:38.000000Z",
    "updated_at": "2026-01-07T03:19:38.000000Z"
  }
]
```

---

### 9. Create Category (Manager/Admin Only)
**Endpoint:** `POST /api/categories`  
**Authentication:** Required (Manager or Admin role)  
**Description:** Create a new category

**Request Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "name": "Electronics",
  "description": "Electronic devices",
  "parent_category_id": null,
  "status": "active"
}
```

**Validation Rules:**
- `name`: required, string, max 255 characters
- `description`: optional, string
- `parent_category_id`: optional, integer, must exist in categories table
- `status`: optional, string (active/inactive)

**Response (201 Created):**
```json
{
  "id": 1,
  "name": "Electronics",
  "description": "Electronic devices",
  "parent_category_id": null,
  "status": "active",
  "created_at": "2026-01-07T03:19:38.000000Z",
  "updated_at": "2026-01-07T03:19:38.000000Z"
}
```

---

### 10. Get Category by ID
**Endpoint:** `GET /api/categories/{id}`  
**Authentication:** Required  
**Description:** Get a specific category by ID

**Request Headers:**
```
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "id": 1,
  "name": "Electronics",
  "description": "Electronic devices",
  "parent_category_id": null,
  "status": "active",
  "created_at": "2026-01-07T03:19:38.000000Z",
  "updated_at": "2026-01-07T03:19:38.000000Z"
}
```

---

### 11. Update Category Status (Assigned Staff Only)
**Endpoint:** `PATCH /api/categories/{id}/status`  
**Authentication:** Required (Policy-based - assigned staff only)  
**Description:** Update category status (active/inactive)

**Request Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "status": "inactive"
}
```

**Validation Rules:**
- `status`: required, string, either "active" or "inactive"

**Response (200 OK):**
```json
{
  "id": 1,
  "name": "Electronics",
  "description": "Electronic devices",
  "parent_category_id": null,
  "status": "inactive",
  "created_at": "2026-01-07T03:19:38.000000Z",
  "updated_at": "2026-01-07T08:22:15.000000Z"
}
```

**Error Response (403 Forbidden):**
```json
{
  "message": "This action is unauthorized."
}
```

---

### 12. Delete Category
**Endpoint:** `DELETE /api/categories/{id}`  
**Authentication:** Required (Policy-based)  
**Description:** Delete a category

**Request Headers:**
```
Authorization: Bearer {token}
```

**Response (204 No Content)**

---

## 🔑 Role-Based Access Control (RBAC)

### Roles & Permissions

| Role | Description | Permissions |
|------|-------------|-------------|
| **admin** | Full system access | All permissions |
| **manager** | Manage products & categories | manage_products, manage_categories |
| **staff** | Limited access | view_products, update_assigned_categories |

### Endpoint Access Rules

| Endpoint | Admin | Manager | Staff |
|----------|-------|---------|-------|
| POST /api/products | ✅ | ✅ | ❌ |
| PATCH /api/products/{id} | ✅ | ✅ (policy) | ❌ |
| DELETE /api/products/{id} | ✅ | ✅ (policy) | ❌ |
| POST /api/categories | ✅ | ✅ | ❌ |
| PATCH /api/categories/{id}/status | ✅ | ❌ | ✅ (if assigned) |
| DELETE /api/categories/{id} | ✅ | ✅ (policy) | ❌ |

---

## 📝 Common Status Codes

| Code | Description |
|------|-------------|
| 200 | OK - Request successful |
| 201 | Created - Resource created successfully |
| 204 | No Content - Successful deletion |
| 400 | Bad Request - Invalid request data |
| 401 | Unauthorized - Missing or invalid token |
| 403 | Forbidden - Insufficient permissions |
| 404 | Not Found - Resource doesn't exist |
| 422 | Unprocessable Entity - Validation failed |
| 500 | Internal Server Error - Server error |

---

## 🧪 Testing Examples

### Example 1: Complete Product Creation Flow

```bash
# 1. Login as admin
curl -X POST http://localhost:8100/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@test.com","password":"password"}'

# Response: Copy the token from response

# 2. Create a category (if needed)
curl -X POST http://localhost:8100/api/categories \
  -H "Authorization: Bearer {your_token}" \
  -H "Content-Type: application/json" \
  -d '{"name":"Electronics","description":"Electronic devices"}'

# 3. Create a product
curl -X POST http://localhost:8100/api/products \
  -H "Authorization: Bearer {your_token}" \
  -H "Content-Type: application/json" \
  -d '{"name":"Laptop","category_id":1,"pricing":999.99,"description":"High-end laptop"}'
```

### Example 2: Update Category Status (Staff)

```bash
# 1. Login as staff
curl -X POST http://localhost:8100/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"staff1@test.com","password":"password"}'

# 2. Update category status (if assigned)
curl -X PATCH http://localhost:8100/api/categories/1/status \
  -H "Authorization: Bearer {your_token}" \
  -H "Content-Type: application/json" \
  -d '{"status":"inactive"}'
```

### Example 3: Get Current User Info

```bash
curl -X GET http://localhost:8100/api/me \
  -H "Authorization: Bearer {your_token}"
```

---

## 🔒 Security Notes

1. **Token Storage**: Store tokens securely (localStorage for web, secure storage for mobile)
2. **Token Expiry**: Tokens expire after a configured time period
3. **HTTPS**: Always use HTTPS in production
4. **CORS**: Configure allowed origins in Laravel config
5. **Rate Limiting**: API endpoints are rate-limited to prevent abuse

---

## 📚 Additional Resources

- Laravel Passport Documentation: https://laravel.com/docs/passport
- API Testing Tool: Postman (https://www.postman.com/)
- JWT Token Inspector: https://jwt.io/

---

**Last Updated:** January 7, 2026
