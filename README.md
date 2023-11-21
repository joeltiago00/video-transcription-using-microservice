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
cd src && \
cp ./pre-commit.disable ./.git/hooks/pre-commit && \
chmod +x .git/hooks/pre-commit
```

To disable pre commit run:
```
mv ./.git/hooks/pre-commit ../.git/hooks/pre-commit-disable
```

To enable again run:
```
mv ./.git/hooks/pre-commit-disable ./.git/hooks/pre-commit
```