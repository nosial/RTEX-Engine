# round

Rounds a number to a given precision.

## Parameters

* value (`integer`, `float`, `double`) - The number to round.
* precision (`integer`) - The number of decimal places to round to. (default: 0)

## Return

(`integer`, `float`, `double`) - The result of the rounding.

## Exceptions

* `EvaluationException` - If there was an error while evaluating one or more parameters.
* `TypeException` - If one or more parameters are not of the expected type.

## Instruction Example

```json
{
  "type": "abs",
  "_": {
    "value": 10
  }
}
```

### Last Updated

Monday, December 30th, 2022.
Written by [Netkas](https://git.n64.cc/netkas)