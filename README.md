## Introduction

The aim of the task is the following:

"So what we are attempting to do with this task is to be able to evaluate you approach to development with our framework of choice, Laravel.

A simple contact form API service is all that is required (no frontend here).

At a minimum we are looking to take a message (name, email address and message) and view messages."

## Proposed Solution

To achieve this, I will create a "messages table" including the following fields:

- user_id
- body

The "user_id" field is a foreign key attached to the user table, to avoid duplicating name and email fields.

I will create a model and resource controller and add an endpoint called "/api/messages".

I will also create another controller which will contain the main generic code, this would allow for esdy, quick expansion moving forward.

The controller will also contain validation, although the specifics will be stored in the model to keep it generic.

I will add "with" parameter functionality to add the user relationship. 

The controller will contain a function to store a message and bring them all back. I will also add the option to filter them.

## File Changes

- New Message model
- New create messages migration file
- New phpunit test file
- New MainController
- New MessageController
- New api route in api.php

## Tests

- Store new message
- Get all messages
- Get filtered messages
