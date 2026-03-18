## GutenbergHub Update SDK

A Gutenberghub private plugins SDK that enables the update feature and mechanism.

## How to use

You can add this SDK into GutenbergHub plugin as a submodule.

1. Navigate inside the gutenberg plugin root and run the following command:

```
git submodule add https://github.com/GutenbergHubOfficial/gutenberghub-sdk gutenberghub-sdk
```

2. Make sure to require the sdk in main PHP file of your plugin. 

3. (Optional) Depending on the git version. You might have to run the following command:

```
git submodule update --init --recursive
```

## How to Update

If you want to update the SDK in your plugin. You can run the following command:

```
git submodule foreach git pull origin main
```
