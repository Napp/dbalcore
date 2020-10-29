# Napp DBAL Core

[![Build Status](https://travis-ci.org/Napp/dbalcore.svg?branch=master)](https://travis-ci.org/Napp/dbalcore)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Napp/dbalcore/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Napp/dbalcore/?branch=master)
[![codecov](https://codecov.io/gh/Napp/dbalcore/branch/master/graph/badge.svg?token=HiDNnCXY03)](https://codecov.io/gh/Napp/dbalcore/branch/master)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)


This package extends the Laravel Query Builder, has a nice `Base Repository` and has a collection of helpful `Criteria` to build queries.



## Repositories

The Basereposity has various helpful methods. 

### Transactions

```php
return $this->transaction(function () use ($data) {
    User::update($data); 
});
```


## Criteria

A `Criterion` is a way to build custom query logic in its own class and reuse within your project. 
Use it together with the BaseRepository to 

```php
$this->criteriaCollection = new CriteriaCollection();
$this->criteriaCollection
    ->reset()
    ->add(new WithRelationCriterion('contentGroups'))
    ->add(new WithRelatedUserCriterion($request->user()))
    ->add(new WithSearchQueryCriterion('foobar', 'name'));

$forms = $this->formsRepository->getAllMatchingCriteria($this->criteriaCollection);
```


## QueryBuilder Usage


This package extends the Laravel QueryBuilder by the following methods:

### Replace

Makes it possible to use the `REPLACE INTO` MySQL grammar in Laravel. Simply do: 

```php
User::replace($data); 
```


### insertOnDuplicateKey

Call `insertOnDuplicateKey` or `insertIgnore` from a model with the array of data to insert in its table.

```php
$data = [
    ['id' => 1, 'name' => 'name1', 'email' => 'user1@email.com'],
    ['id' => 2, 'name' => 'name2', 'email' => 'user2@email.com'],
];

User::insertOnDuplicateKey($data);

User::insertIgnore($data);
```

#### Customizing the ON DUPLICATE KEY UPDATE clause

##### Update only certain columns

If you want to update only certain columns, pass them as the 2nd argument.

```php
User::insertOnDuplicateKey([
    'id'    => 1,
    'name'  => 'new name',
    'email' => 'foo@gmail.com',
], ['name']);
// The name will be updated but not the email.
```

##### Update with custom values

You can customize the value with which the columns will be updated when a row already exists by passing an associative array.

In the following example, if a user with id = 1 doesn't exist, it will be created with name = 'created user'. If it already exists, it will be updated with name = 'updated user'.

```php
User::insertOnDuplicateKey([
    'id'    => 1,
    'name'  => 'created user',
], ['name' => 'updated user']);
```

The generated SQL is:

```sql
INSERT INTO `users` (`id`, `name`) VALUES (1, "created user") ON DUPLICATE KEY UPDATE `name` = "updated user"
```

You may combine key/value pairs and column names in the 2nd argument to specify the columns to update with a custom literal or expression or with the default `VALUES(column)`. For example:

```php
User::insertOnDuplicateKey([
    'id'       => 1,
    'name'     => 'created user',
    'email'    => 'new@gmail.com',
    'password' => 'secret',
], ['name' => 'updated user', 'email]);
```

will generate

```sql
INSERT INTO `users` (`id`, `name`, `email`, `password`)
VALUES (1, "created user", "new@gmail.com", "secret")
ON DUPLICATE KEY UPDATE `name` = "updated user", `email` = VALUES(`email`)
```

### Pivot tables

Call `attachOnDuplicateKey` and `attachIgnore` from a `BelongsToMany` relation to run the inserts in its pivot table. You can pass the data in all of the formats accepted by `attach`.

```php
$pivotData = [
    1 => ['expires_at' => Carbon::today()],
    2 => ['expires_at' => Carbon::tomorrow()],
];

$user->roles()->attachOnDuplicateKey($pivotData);

$user->roles()->attachIgnore($pivotData);
```
