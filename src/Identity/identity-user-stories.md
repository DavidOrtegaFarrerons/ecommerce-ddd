# Identity — User Stories

This document describes the authentication-related user stories for the e-commerce system.  
They capture the needs of both visitors and customers regarding identity and session management.

---

## Visitor

### Register with Email and Password
- **As a visitor**, I want to **register with my email and password**,  
  so I can create an account.

**Details:**
- Registration requires a valid, unique email address.
- Passwords must meet security requirements (minimum length, complexity).
- A new account starts with default role: `ROLE_USER`.

---

## Customer

### Log In
- **As a customer**, I want to **log in with my credentials**,  
  so I can access my cart and place orders.

**Details:**
- Login requires a valid email and password.
- If credentials are invalid, the system must respond with a clear error.

---

### Stay Logged In (Session)
- **As a customer**, I want to **stay logged in for a short time**,  
  so I don’t have to re-authenticate on every request.

**Details:**
- Session should be valid for a limited period (configurable).
- Expired or invalid sessions must require re-login.

---

## Acceptance Criteria

- Users can register, log in, and remain authenticated for a session duration.
- System prevents duplicate registrations with the same email.
- Passwords are always stored as hashes.
- Authentication failures return clear error messages.
- Tokens/sessions expire according to configured policies.
