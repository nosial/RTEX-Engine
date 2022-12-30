# pow

Calculates the power of a number.

## Parameters

* a (`integer`, `float`, `double`) - The number to raise to a power.
* b (`integer`, `float`, `double`) - The power to raise the number to.

## Return

(`integer`, `float`, `double`) - The result of the power calculation.

## Exceptions

* `EvaluationException` - If there was an error while evaluating one or more parameters.
* `TypeException` - If one or more parameters are not of the expected type.

## Instruction Example

```json
{
  "type": "pow",
  "_": {
    "a": 2,
    "b": 3
  }
}
```

### Last Updated

Monday, December 30th, 2022.
Written by [Netkas](https://git.n64.cc/netkas)