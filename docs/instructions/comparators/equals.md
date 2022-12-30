# eq

Returns true if the two values are equal, false otherwise.

## Parameters

* a (`integer`, `float`, `double`, `string`, `boolean`) - The first value to compare.
* b (`integer`, `float`, `double`, `string`, `boolean`) - The second value to compare.

## Return

(`boolean`) - True if the two values are equal, false otherwise.

## Exceptions

* `EvaluationException` - If there was an error while evaluating one or more parameters.
* `TypeException` - If one or more parameters are not of the expected type.


## Instruction Example

```json
{
  "type": "eq",
  "_": {
    "a": "foo",
    "b": "foo"
  }
}
```

### Last Updated

Monday, December 30th, 2022.
Written by [Netkas](https://git.n64.cc/netkas)