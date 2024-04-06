git pull
docker build --no-cache -t triastartya/api-retail:$(date '+%d%m%Y%H%M%S')
docker push triastartya/api-retail:$(date '+%d%m%Y%H%M%S')
docker tag triastartya/api-retail:$(date '+%d%m%Y%H%M%S') triastartya/api-retail:dev-latest
docker push triastartya/api-retail:dev-latest