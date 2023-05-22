kubectl apply -f devops/production/kubernetes/doppler/config.yml

kubectl create secret generic \
  trustup-io-app-token-secret \
  -n doppler-operator-system  \
  --from-literal=serviceToken=dp.st.prd.gFJmmLMFmZDKaTIGYnYiVIVS5rhqa9yQzkdGDpQItKK (stored in repository secret as DOPPLER_ACCESS_TOKEN_TRUSTUP_IO_APP)
  
kubectl create secret generic \
  trustup-io-app-commons-token-secret \
  -n doppler-operator-system  \
  --from-literal=serviceToken=dp.st.prd.lKqBHiWN0guxacFyO2hS7ilV0DXiX2iWEE8W9LGKcWB  (stored in organization secret as DOPPLER_ACCESS_TOKEN_TRUSTUP_IO_APP_COMMONS)

kubectl create secret generic \
  trustup-io-ci-commons-token-secret \
  -n doppler-operator-system  \
  --from-literal=serviceToken=dp.st.prd.VtQYA2buD0waFe4yQyBKN6kdlzo6bqy6SEQZY8xRLQ5  (stored in repository secret as DOPPLER_ACCESS_TOKEN_TRUSTUP_IO_CI_COMMONS)

kubectl apply -f devops/production/kubernetes/doppler/secrets --recursive