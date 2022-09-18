import requests as req
from bs4 import BeautifulSoup

url_api = 'http://apis-back-symf/api/city/1/places'
url_web = 'https://yandex.ru/images/search?from=tabbar&text=great%20wall%20of%20china'

with(req.get(url_web)) as response:

    if response.status_code == 200:

        html = response.text
        soup = BeautifulSoup(html, 'lxml')
        imgs = soup.find_all('img', class_='serp-item__thumb')

        for img in imgs:
            print("{0}: {1}: {2}".format(img.name, img['class'], img['src']))

    else:
        print("couldn't receive images")
        