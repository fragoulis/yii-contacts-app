#!/bin/sh

cd app/tests

phpunit --colors unit

cd ../..

git commit -a
git push
git subtree push --prefix=app/extensions/contacts --squash yii-contacts master