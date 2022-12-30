# mul

Calculates the multiplication of two numbers.

## Parameters

* a (`integer`, `float`, `double`) - The number to multiply.
* b (`integer`, `float`, `double`) - The number to multiply by.

## Return

(`integer`, `float`, `double`) - The result of the multiplication.

## Exceptions

* `EvaluationException` - If there was an error while evaluating one or more parameters.
* `TypeException` - If one or more parameters are not of the expected type.

## Instruction Example

```json
{
  "type": "mul",
  "_": {
    "a": 10,
    "b": 3
  }
}
```

### Last Updated

Monday, December 30th, 2022.
Written by [Netkas](https://git.n64.cc/netkas)