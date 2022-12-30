# set

Sets aor overwrites a variable in the environment.

## Parameters

* name (`string`, `instruction`) - The name of the variable to get.
* value (`any`, `instruction`) - The value to set.

## Return

(`null`) - Nothing.

## Exceptions

* `EvaluationException` - If there was an error while evaluating one or more parameters.
* `TypeException` - If one or more parameters are not of the expected type.


## Instruction Example

```json
{
  "type": "set",
  "_": {
    "name": "foo",
    "value": "bar"
  }
}
```

### Last Updated

Monday, December 29th, 2022.
Written by [Netkas](https://git.n64.cc/netkas)