# 💰 Sales Transaction Processing System (TechSales)

## Description / Overview
**TechSales** is an easy-to-use web application developed with **Laravel** that assists in managing sales transactios, customer data, and product stock. It enable users to insert, modify, view, and remove information concerning customers, products, and sales. The goal of the system is to streamline everyday sales activities and enhance record management for small enterprises.

## Objectives
- Utilize the **MVC Framework** with Laravel.
- Create **CRUD functionalities** for Sales, Customers, and Products.
- Develop a **sleek**, **responsive design** employing Tailwind CSS.
- Showcase fundamental **database relationships** and perform data validation.
  
## Features / Functionality
### **Customer Management**
- Add view, modify, and remove customer entries.
- Save customer name, email address, phone number, and location.

### **Product Management**
- Oversee product inventory including SKU, pricing, and stock levels.
- Easily update inventory and price information.

### **Sales Management**
- Generate and monitor sales transactions.
- Link customers and products to each transaction.
- Automatically calculate totalls and oversee sale status(Pending, Completed).

### **Navigation**
- Sidebar shortcuts for quick access: **Sales**, **Customers**, **Products**.
- Quick Action buttons for adding new entries.

## Installation Instructions
### Step-by-Step Installation
**1. Clone or Download the project**
- Download the ZIP file or clone repository using:
  
  `git clone https://github/your-repo-link.git`

**2. Install Dependencies**
- Install all PHP dependencies via Composer:
  
  `composer install`
  
**3. Environment Configuration**
- Copy the example environment file:
  
  `cp .env.example .env`
- Generate the application key:
  
  `php artisan key:generate`
- Open .env file and update the lines to match the database setup
  
**4. Create the Database**
- Open MySQL client and create a new database:
  
  `CREATE DATABASE myTps;`
  
**5. Run Migrations**
- Create all the necessary tables:
  
  `php artisan migrate`
  
**6. Seed Data (optional)**
- To quickly test the system with sample data, run:
  
  `php artisan db:seed`
  
**7. Start the Development Server**
- Launch the laravel server:
  
  `php artisan serve`
  
## Usage
**1. Access the Website**

Open browser and go to: [TechSales](http://127.0.0.1:8000/sales)

**2. Customer Management**

**Add a New Customer**

- Go to Customers → *Add Customer*
- Fill in the customer details: **Name**, **Email**, **Phone**, **Address**
- Click **create customer**

**Edit Customer**
- Go to Customers → *Edit beside a record*
- Update the information
- Click **update customer**

**Delete Customer**
- Click **delete** beside the customer record
- Confirm deletion

**3. Product Management**

**Add Product**
- Go to products → *Add product*
- Fill out: **Product Name**, **SKU**, **Price**, **Stock Quantity**
- Click **create product**

**Manage Stock**
- Edit the product to restock or update prices.

**4. Sales Transaction Processing**

**Create a New Sale**
- Go to Sales → *New Sale*
- Select a **customer** from the dropdown
- Add one or more **products** with quantity
- The total will be calculated automatically
- Add tax or discount (optional)
- Click **create sale**

**View Sale Details**
- Go to Sales → *View*
- You can see the customer info, invoice number, sale data, and item details.

**Update Sale Status**
- Status options: **Pending**, **Completed**, **Cancelled**
  
**5. Common Use Cases**
**Daily Sales**
- Add customer → Add product → Create sale → View invoice

**Inventory Restock**
- Edit product → Update stock quantity → Save changes

***Use **Quick Actions** in the sidebar for faster access***

## Screenshots 

- **Sales Management Part**
  
  ![Sales](https://github.com/user-attachments/assets/056ed5f2-ea3d-46d5-9367-d5d73949a9c8)
- **Add Sales Page**
  
  ![Addsales](https://github.com/user-attachments/assets/8b10c7c1-2b3e-4b49-995c-548a08b03bc4)
- **Customer Management Part**
  
  ![Customer](https://github.com/user-attachments/assets/d1b721f3-48c0-4ceb-a20e-0a604ebda19a)
- **Add Customer Page**
  
  ![Addcustomer](https://github.com/user-attachments/assets/8f446b45-01f0-45c8-b092-a43c166398c0)
- **Products Management Part**
  
  ![Products](https://github.com/user-attachments/assets/fff2c9f2-c6b9-4ee6-a946-c6f7c3fc10fb)
- **Add Products Page**
  
  ![Addproducts](https://github.com/user-attachments/assets/162cf3cc-3e25-46b2-a2a5-ff0f67943068)
- **Sidebar Part**
  
  ![Sidebar](https://github.com/user-attachments/assets/b30dc666-019c-4d48-bb20-6e7538a4897a)

## Contributors
  |        Name      |       Role       |
  |------------------|------------------|
  |**Queenie Flores**| Project Developer|
  | **Bryan Mamuyac**| Project Developer|

## License

This project is licensed for **Academic Purposes Only**
```
Copyright (c) Queenie Leanne Flores

It may be used for research, school projects, and educational demonstrations. All rights reserved (c) 2025.
