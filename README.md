# Pregnancy Clinic Management System BUMIL Care

## Overview
A comprehensive clinic management system specifically designed for pregnancy and maternal healthcare services. This system streamlines patient management, medical examinations, pharmacy operations, and payment processing.

## Features
- Patient Management
- Queue System
- Medical Examination
- Prescription Management
- Pharmacy Operations
- Payment Processing
- Pregnancy Records

## User Roles
1. **Admin**
   - Manage patients
   - Manage queues
   - Access all features

2. **Doctor**
   - Conduct examinations
   - Create prescriptions
   - View patient history

3. **Nurse**
   - Register patients
   - Manage queues
   - Record basic patient information

4. **Pharmacist**
   - Process prescriptions
   - Manage medicine inventory
   - Dispense medications

5. **Cashier**
   - Process payments
   - Generate invoices
   - Manage payment records

## Application Flow

### 1. Patient Registration
- Register new patient
- Create pregnancy record (if applicable)
- Managed by admin/nurse

### 2. Queue Management
- Create patient queue
- Assign doctor
- Display queue status
- Managed by admin/nurse

### 3. Medical Examination
- Doctor examines patient
- Record examination details
- Create prescription if needed
- View patient history

### 4. Pharmacy Process
- View new prescriptions
- Process and prepare medicines
- Update prescription status
- Manage medicine inventory

### 5. Payment Processing
#### Examination Payment
- Create payment record
- Process payment
- Generate invoice

#### Medicine Payment
- Create prescription payment
- Process payment
- Generate invoice

### 6. Records & History
- Patient medical history
- Examination records
- Payment history
- Pregnancy progress records

## Payment Methods
- Cash
- Debit Card
- Credit Card
- Insurance

## Document Generation
- Examination reports
- Prescriptions
- Payment invoices
- Medical history records

## Security
- Role-based access control
- Secure authentication
- Protected patient data
- Transaction logging

## Requirements
- PHP 8.1+
- Laravel 10.x
- MySQL 8.0+
- Bootstrap 5.x
- Modern web browser

## Installation
```bash
# Clone repository
git clone [repository-url]

# Install dependencies
composer install
npm install

# Set up environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Start development server
php artisan serve
```

## License
[License Type]

## Support
[Contact Information]