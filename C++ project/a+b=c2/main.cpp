#include <iostream>

using namespace std;

int main()
{
    int a,b,c;
    cin>>c;
    for(a=0;a*a<=c;a++)
    {
        for(b=0; b*b<c;b++)
            if(a*a+b*b==c)
            cout<<a<<'_'<<b<<endl;
    }
    return 0;
}
