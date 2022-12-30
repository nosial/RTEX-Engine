# floor

Returns the floor value of a number.

## Parameters

* value (`integer`, `float`, `double`) - The number to get the floor value of.

## Return

(`integer`, `float`, `double`) - The result of the floor value.

## Exceptions

* `EvaluationException` - If there was an error while evaluating one or more parameters.
* `TypeException` - If one or more parameters are not of the expected type.

## Instruction Example

```json
{
  "type": "floor",
  "_": {
    "value": 10.5
  }
}
```

### Last Updated

Monday, December 30th, 2022.
Written by [Netkas](https://git.n64.cc/netkas)