queuezilla
==========

A deprecated consumer of the Netflix API, this project allows a Netflix customer to manage multiple queues in bulk, allows customers to share queues with each other, can receive commands via XMPP messages to a bot, and fuzzily converts Blockbuster Online queues via a levenshtein distance algorithm

Based on CakePHP MVC framework and Netflix API (which has been closed to most all developers)

Most of the code that matters is in:
* app/vendors/OAuth/netflix_consumer.php
* app/controllers/queues_controller.php
* app/vendors/xmpphp-0.1rc2-r77/cli_longrun_example_mine.php


The basics of how the apps are:
User goes to the app in their browser
The app redirects the user to the Netflix OAuth permissions page
User grants permission and comes back to the app
App gets the OAuth token for the user from the callback URL. App can now make calls to Netflix API on behalf of user.
App can: Add and remove titles from a queue, delete a queue in bulk, load a queue in bulk, save queues, etc. 

If the API still worked, the area to improve would be a bulk update to a user's queue. At the time Netflix did not support bulk operations.
