git pull origin development
docker build --no-cache -t triastartya/api-retail:$(date '+%d%m%Y%H%M')
docker push triastartya/api-retail:$(date '+%d%m%Y%H%M')
docker tag triastartya/api-retail:$(date '+%d%m%Y%H%M') triastartya/api-retail:dev-latest
docker push triastartya/api-retail:dev-latest