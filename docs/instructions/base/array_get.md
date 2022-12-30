# array_get

Get an item from an array using "dot" notation.

## Parameters

* array (`array`) - The array to get the value from.
* key (`string`) - The key to get the value for.

## Return

(mixed) - The value of the key or throws an exception if the key is not found.

## Exceptions

* `EvaluationException` - If there was an error while evaluating one or more parameters.
* `KeyException` - If the key is not found.
* `TypeException` - If one or more parameters are not of the expected type.

## Instruction Example

```json
{
  "type": "array_get",
  "_": {
    "array": {
      "foo": {
        "bar": "baz"
      }
    },
    "key": "foo.bar"
  }
}
```

### Last Updated

Monday, December 26th, 2022.
Written by [Netkas](https://git.n64.cc/netkas)