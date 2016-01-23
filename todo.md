# Basic project setup

## Auth
- [ ] Create user controller
- [ ] Set up auth provider
- [ ] Registration
- [ ] Login
- [ ] Permissions per page


## Models
- Users
 - [ ] Name
 - [ ] Email
 - [ ] Password
 - [ ] Role (Admin, Applicant, Judge, Observer)

- Questions
 - [ ] Question
 - [ ] Type (Input, Text, Dropdown, Boolean)
 - [ ] Options (JSON, Optional, used for dropdowns, and for weighted booleans)
 - [ ] Status (This question will only appear when an application is within a specific status)
 - [ ] Required
 - [ ] Parent

- Criteria
 - [ ] Criteria
 - [ ] Type (Dropdown, Boolean)
 - [ ] Options (JSON, Optional, used for dropdowns, and for weighted booleans)

- Applications
 - [ ] Status (New, Submitted, Review, Follow Up, Accepted, Rejected)
 - [ ] ???

- Files
 - [ ] Name
 - [ ] Description
 - [ ] File
 - [ ] Application ID


## Pages
- [ ] Home page
- [ ] User dashboard
- [ ] Admin dashboard
- [ ] Judge dashboard
- [ ] Create question
- [ ] Create criteria
- [ ] Create application
- [ ] Answering questions
- [ ] Judging applications
- [ ] Follow up questions


## Relationships
- [ ] Relationship between users and applications
- [ ] Relationship between applications and questions ???
- [ ] Relationship between applications and criteria ???


## Defined Events
- [ ] User Registered
- [ ] Application Submitted
- [ ] Application Needs Review
- [ ] Application Accepted
- [ ] Application Rejected


## Event Handlers
- [ ] Send user email when user is registered
- [ ] Send judges email when application is submitted
- [ ] Send user email when application needs review
- [ ] Send user email when application is accepted
- [ ] Send user email when application is rejected
