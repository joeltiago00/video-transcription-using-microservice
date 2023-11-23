### Setup application

1 - Give executable permission to run script:
```
chmod +x setup.sh
```

2 - Run script to configure whole application:
```
./setup.sh
```

###  Pre Commit Script

To make first enable run: 
```
cp ./pre-commit-disabled ./.git/hooks/pre-commit && \
chmod +x .git/hooks/pre-commit
```
[pre-commit](.git%2Fhooks%2Fpre-commit)
To disable pre commit run:
```
mv ./.git/hooks/pre-commit ../.git/hooks/pre-commit-disabled
```

To enable again run:
```
mv ./.git/hooks/pre-commit-disabled ./.git/hooks/pre-commit
```