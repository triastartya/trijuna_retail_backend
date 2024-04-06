git pull origin development
uuid=uuidgen
docker build --no-cache -t triastartya/api-retail:$uuid .
docker push triastartya/api-retail:$uuid
docker tag triastartya/api-retail:$uuid triastartya/api-retail:latest
docker push triastartya/api-retail:latest 