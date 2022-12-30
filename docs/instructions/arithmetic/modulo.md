# mod

Calculates the remainder of a division operation.

## Parameters

* a (`integer`, `float`, `double`) - The number to divide.
* b (`integer`, `float`, `double`) - The number to divide by.

## Return

(`integer`, `float`, `double`) - The result of the modulo operation.

## Exceptions

* `EvaluationException` - If there was an error while evaluating one or more parameters.
* `TypeException` - If one or more parameters are not of the expected type.

## Instruction Example

```json
{
  "type": "mod",
  "_": {
    "a": 10,
    "b": 3
  }
}
```

### Last Updated

Monday, December 30th, 2022.
Written by [Netkas](https://git.n64.cc/netkas)