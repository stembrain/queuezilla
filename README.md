queuezilla
==========

A deprecated consumer of the Netflix API, this project allows a Netflix customer to manage multiple queues in bulk, allows customers to share queues with each other, can receive commands via XMPP messages to a bot, and fuzzily converts Blockbuster Online queues via a levenshtein distance algorithm

Based on CakePHP MVC framework and Netflix API (which has been closed to most all developers)

Most of the code that matters is in:
* app/vendors/OAuth/netflix_consumer.php
* app/controllers/queues_controller.php
