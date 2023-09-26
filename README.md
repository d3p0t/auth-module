
# Routes

## Admin Routes

| Name | Method | Description |
| ---- | ------ | ------ |
| auth::admin.login.show           | GET  | Show Login Page   |
| auth::admin.login                | POST | Logs the user in  |
| auth::admin.logout               | GET  | Logs the user out |  
| auth::admin.forgot-password.show | GET  | Shows the forgot password Page |
| auth::admin.forgot-password      | POST | Sends a reset password mail    |
| auth::admin.reset-password.show  | GET  | Shows the reset password Page  |
| auth::admin.reset-password       | POST | Resets the password |
| auth::admin.profile              | GET  | Shows the Profile Page |
| auth::admin.users.index          | GET  | Shows the User overview Page |
| auth::admin.users.create         | GET  | Shows the Create User Page |
| auth::admin.users.store          | POST | Creates a new User |
| auth::admin.users.edit           | GET  | Shows the Edit User Page |
| auth::admin.users.update         | POST | Updates a User |
| auth::admin.users.delete         | GET  | Deletes a User | 
| auth::admin.roles.index          | GET  | Shows the Role overview Page |
| auth::admin.roles.create         | GET  | Shows the Create Role Page |
| auth::admin.roles.store          | POST | Creates a new Role |
| auth::admin.roles.edit           | GET  | Shows the Edit Role Page |
| auth::admin.roles.update         | POST | Updates a Role |
| auth::admin.roles.delete         | GET  | Deletes a Role |

## Public Routes

| Name | Method | Description |
| ---- | ------ | ------ |
| auth::login.show           | GET  | Shows the Login Page |
| auth::login                | POST | Logs the User in |
| auth::logout               | GET  | Logs the User out |
| auth::forgot-password.show | GET  | Shows the Forgot Password Page |
| auth::forgot-password      | POST | Sends a Password Reset mail |
| auth::reset-password.show  | GET  | Shows the Password Reset Page |
| auth::reset-password       | POST | Resets the Password |
| auth::profile              | GET  | Shows the Profile Page |
| auth::profile              | POST | Updates the Profile | 

