Test task for MyQ

##RUN INSTRUCTIONS
1. Clone repository `git clone git@github.com:gevorg2020/my_q_test_task.git`
2. `cd my_q_test_task`
3. Build docker container `docker-compose up -d --build`
4. Composer dependency update `docker-compose exec php composer update`
5. Run cleaning robot `docker-compose exec php php bin/console robot:run path-to-input-file path-to-output-file`
6. Run unit test `docker-compose exec php php bin/phpunit`
