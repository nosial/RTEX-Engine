# sub

Subtract two numbers.

## Parameters

* a (`integer`, `float`, `double`) - The number to subtract from.
* b (`integer`, `float`, `double`) - The number to subtract.

## Return

(`integer`, `float`, `double`) - The result of the subtraction.

## Exceptions

* `EvaluationException` - If there was an error while evaluating one or more parameters.
* `TypeException` - If one or more parameters are not of the expected type.

## Instruction Example

```json
{
  "type": "sub",
  "_": {
    "a": 10,
    "b": 2
  }
}
```

### Last Updated

Monday, December 30th, 2022.
Written by [Netkas](https://git.n64.cc/netkas)