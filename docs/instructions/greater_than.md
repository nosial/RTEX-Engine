# greater_than

Returns true if the first argument is greater than the second argument.

## Parameters

* a (`integer`, `float`, `double`, `instruction`) - The first number.
* b (`integer`, `float`, `double`, `instruction`) - The second number.

## Return

(`boolean`) - True if the first argument is greater than the second argument.

## Exceptions

* `EvaluationException` - If there was an error while evaluating one or more parameters.
* `TypeException` - If one or more parameters are not of the expected type.

## Instruction Example

```json
{
  "type": "greater_than",
  "_": {
    "a": 10,
    "b": 2
  }
}
```

### Last Updated

Monday, December 29th, 2022.
Written by [Netkas](https://git.n64.cc/netkas)