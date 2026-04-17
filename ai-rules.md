# Project Coding Rules (Library Management System - Quản Lý Thư Viện)

## 1. Project Structure
- **React Components**: `resources/js/Components`
- **React Pages (Inertia)**: `resources/js/Pages`
- **Classic Views**: `resources/views/pages`
- **Controllers**: `app/Http/Controllers/Pages`
- **Models**: `app/Models`
- **Assets**: `public/js`, `public/css`

## 2. Naming Conventions
- **React Components**: PascalCase (e.g., `BookCatalog.jsx`)
- **React Hooks**: camelCase starting with `use` (e.g., `useBorrowing.js`)
- **API Functions**: camelCase (e.g., `getBookList`, `processLoan`)
- **Database Fields**: snake_case (e.g., `author_id`, `published_year`)
- **Blade Files**: camelCase or snake_case (standard: `bookDetail.blade.php`)
- **Variable names (PHP/JS)**: camelCase

## 3. API & Data Pattern
- **Library**: Use `axios` for all asynchronous requests.
- **Inertia**: Use `router.post()` or `router.get()` for navigation-driven actions in React.
- **Classic**: Use `$.ajax` or `axios` in jQuery scripts.
- **Standard Return Format**:
  ```json
  {
    "success": boolean,
    "data": any,
    "message": string
  }
  ```

## 4. UI Frameworks & UX Standard (Professional & Beautiful)
- **Design Philosophy**: Modern, Clean, and Intellectual. Use rich typography and generous white space.
- **Color Palette**: 
    - *Primary*: Deep Navy (`#003A4F`) for authority and depth.
    - *Secondary*: Gold/Antique Gold (`#CDC717`) for highlights.
    - *Background*: Soft neutrals (`#F8F9FA` or slight parchment tints).
- **React Components**: Use **React Bootstrap** for layouts and **PrimeReact** for lists/tables.
- **Modern Effects**: 
    - Use **Glassmorphism** for modals and floating navbars.
    - Implement **Smooth Transitions** (0.3s) for all hover states.
    - Use **Soft Rounded Corners** (border-radius: 12px) for cards and inputs.
- **Icons**: Lucide Icons or FontAwesome 6 (Duotone preferred).
- **Notifications**: Always use **SweetAlert2 (Swal)** with custom "Dark" or "Glass" themes.
- **Typography Standards**: 
    - *Base Font*: Always use **Arimo** (Sans-serif) for the entire project.
    - *Headings (e.g., "THÀNH VIÊN")*: Use **Arimo** with high weight (bold) and `letter-spacing: 1px`.
    - *Text Transform*: Headings for modules should be **UPPERCASE**.
- **Form Standards**:
    - Use **Floating Labels** for all input forms to maintain a clean UI.
    - Border-radius must be exactly `12px` for all input fields and containers.
    - Soft shadows (`box-shadow: 0 4px 6px rgba(0,0,0,0.05)`) should be applied to all form cards.

## 5. Coding Logic
- **Separation of Concerns**: Keep UI components clean; move complex business logic to Custom Hooks (React) or Helper classes (PHP).
- **Date Handling**: Use **Carbon** in PHP and **dayjs** or `Date` objects in JS. Format for DB: `YYYY-MM-DD HH:mm:ss`.
- **Validation**: Always validate data on the Backend using Laravel Request Validation.

## 6. Error Handling
- **Async/API**: Always wrap API calls in `try/catch` blocks.
- **Backend**: Use `try/catch` for database transactions and return meaningful error messages.
- **Feedback**: Show toast messages for success/error if no redirect is involved.

## 7. Performance & Integrity
- **Database**: Use Eloquent relationships where possible. Avoid N+1 query problems.
- **Data Integrity**: Implement strict permission checks at the top of Views and inside Controllers (`user_has_permission`).
- **Locks**: Disable editing/saving for historical data (past dates) to maintain records integrity.
