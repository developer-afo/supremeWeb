# Laravel Wallet Application

## Introduction

This Laravel application allows users to have multiple wallets. Each wallet type has its own name, minimum balance, and monthly interest rate. Wallets can send and receive money from other wallets. The application includes endpoints for creating wallets, wallet types, and funding wallets, as well as viewing users and wallets.

## Prerequisites

-   PHP >= 7.4
-   Composer
-   MySQL database

## Installation

### Step 1: Clone the Repository

First, clone the repository to your local machine:

```sh
git clone https://github.com/developer-afo/supremeWeb.git
cd laravel-wallet-app
```

### Step 2: Install Dependencies

Install the PHP dependencies using Composer:

```sh
composer install
```

### Step 3: Environment Setup

Copy the `.env.example` file to `.env` and configure your environment variables, especially the database settings:

```sh
cp .env.example .env
```

Open the `.env` file and set the following variables:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

Generate an application key:

```sh
php artisan key:generate
```

### Step 4: Run Migrations

Run the database migrations to create the necessary tables:

```sh
php artisan migrate
```

### Step 5: Start the Server

Start the Laravel development server:

```sh
php artisan serve
```

Your application should now be running at `http://127.0.0.1:8000`.

## API Endpoints

### 1. Send Money

-   **Endpoint**: `/api/register`
-   **Method**: `POST`
-   **Description**: User register.
-   **Request Body**:
    -   `first_name`: string, optional
    -   `last_name`: string, optional
    -   `email`: string, required
    -   `password`: string, required,minimum length of 8 characters
-   **Response**:
    -   `status`: `success`
    -   `msg`: "Money sent successfully"
    -   `data`: null

### 2. Login

-   **Endpoint**: `/api/login`
-   **Method**: `POST`
-   **Description**: User login.
-   **Request Body**:
    -   `email`: string, required
    -   `password`: string, required
-   **Response**:
    -   `status`: `success`
    -   `msg`: "Money sent successfully"
    -   `data`: null

### 3. Get All Users

-   **Endpoint**: `/api/user/all`
-   **Method**: `GET`
-   **Description**: Retrieves all users in the system.
-   **Response**:
    -   `status`: `success`
    -   `msg`: "All users fetched successfully"
    -   `data`: List of users

### 4. Get All Wallets

-   **Endpoint**: `/api/user/wallet/all`
-   **Method**: `GET`
-   **Description**: Retrieves all wallets in the system.
-   **Response**:
    -   `status`: `success`
    -   `msg`: "All wallets fetched successfully"
    -   `data`: List of wallets

### 5. Get Wallet Details

-   **Endpoint**: `/api/user/wallet/details/{id}`
-   **Method**: `GET`
-   **Description**: Retrieves details of a specific wallet including its owner, type, and available balance.
-   **Response**:
    -   `status`: `success`
    -   `msg`: "Wallet details fetched successfully"
    -   `data`: Wallet details

### 6. Create Wallet Type

-   **Endpoint**: `/api/user/wallet/create-type`
-   **Method**: `POST`
-   **Description**: Creates a new wallet type.
-   **Request Body**:
    -   `name`: string, required
    -   `minimum_balance`: numeric, required
    -   `monthly_interest_rate`: numeric, required
-   **Response**:
    -   `status`: `success`
    -   `msg`: "Wallet type created successfully"
    -   `data`: Created wallet type

### 7. Create Wallet

-   **Endpoint**: `/api/user/wallet/create`
-   **Method**: `POST`
-   **Description**: Creates a new wallet for the authenticated user.
-   **Request Body**:
    -   `wallet_type_id`: integer, required
-   **Response**:
    -   `status`: `success`
    -   `msg`: "Wallet created successfully"
    -   `data`: Created wallet

### 8. Fund Wallet

-   **Endpoint**: `/api/user/wallet/fund`
-   **Method**: `POST`
-   **Description**: Funds a wallet for the authenticated user.
-   **Request Body**:
    -   `wallet_id`: integer, required
    -   `amount`: numeric, required
-   **Response**:
    -   `status`: `success`
    -   `msg`: "Wallet funded successfully"
    -   `data`: Updated wallet

### 9. Send Money

-   **Endpoint**: `/api/user/wallet/send-money`
-   **Method**: `POST`
-   **Description**: Sends money from one wallet to another.
-   **Request Body**:
    -   `from_wallet_id`: integer, required
    -   `to_wallet_id`: integer, required
    -   `amount`: numeric, required
-   **Response**:
    -   `status`: `success`
    -   `msg`: "Money sent successfully"
    -   `data`: null

## Authentication

The endpoints require the user to be authenticated, and you should include the authentication token in your request headers.

## Conclusion

This application provides a simple way to manage multiple wallets for users, allowing for transactions between wallets. Follow the steps outlined above to set up and run the application. The provided endpoints cover the basic functionalities needed to interact with the wallets and users.
